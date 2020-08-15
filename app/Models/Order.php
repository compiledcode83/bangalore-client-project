<?php

namespace App\Models;

use App\Mail\OrderConfirmation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class Order extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = ['deleted_at'];


    /**
     * The attributes that must be protected from mass assignment.
     * @var array
     */
    protected $guarded = ['id'];

    const IS_PAID = 5 ; //Status in statues table
    const NOT_PAID = 6 ; //Status in statues table
    /**
     * Get the user owns this wishList
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get items for the Order.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
    /**
     * Get payment Transaction for the Order.
     */
    public function orderTransactions()
    {
        return $this->hasMany(OrderTransactions::class, 'order_id');
    }

    /**
     * Get statuses for the Order.
     */
    public function orderStatuses()
    {
        return $this->hasMany(OrderStatus::class);
    }

    /**
     * Get Related reviews for the order.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Create new Order.
     * @param $user
     * @return
     */
    public function store($user, $data)
    {
        $cart = $user->cart;

        $shippingAddress = UserAddress::find($data['shippingAddress']);
        $governorate = Governorate::find($shippingAddress->governorate);
        $area = Area::find($shippingAddress->area);
        $billingAddress = $data['defaultBillingAddress'];

        try{

            $prepareShippingAddress = $governorate->name_en.', '.$area->name_en.', block: '.$shippingAddress->block.', street: '. $shippingAddress->street.', building: '.$shippingAddress->building.', floor: '. $shippingAddress->floor;
        }catch (\Exception $e){
            return ['error' => 'complete your address pleae!'];
        }

        if($user->type == User::TYPE_USER)
        {
            $prepareShippingAddress .= ', home: '. $shippingAddress->house_number;
        }
        else
        {
            $prepareShippingAddress .= ', office: '. $shippingAddress->office_number.', office address: '. $shippingAddress->office_address;
        }

        $prepareBillingAddress = $prepareShippingAddress;
        if(!$data['billingShipping'])
        {
               $prepareBillingAddress = $billingAddress['governorate']. ', '. $billingAddress['area'].', block: '.
                $billingAddress['block'].', street: '. $billingAddress['street'].', building: '. $billingAddress['building'].
                ', floor: '. $billingAddress['floor'];

            if($user->type == User::TYPE_USER)
            {
                $prepareBillingAddress .= ', home: '. $shippingAddress['house_number'];
            }
            else
            {
                $prepareBillingAddress .= ', office: '. $shippingAddress['office_number'].', office address: '. $shippingAddress['office_address'];
            }
        }

        $order = new Order( [
            'order_code'  => Str::random(5),
            'final_status' => 'pending',
            'address'    => $prepareShippingAddress,
            'billing_address' => $prepareBillingAddress,
            'sub_total' => 0,
            'total_discount' => $data['discount'] ?? 0,
            'delivery_charges' => $data['delivery'] ?? 0,
            'total' =>  0,
            'payment_method' => $data['paymentMethod']
        ] );

        $user->orders()->save($order);

        $items = [];
        $emailConfirmationData = [];
        $itemsSubTotal = 0;
        foreach($cart->cartItems as $item)
        {
            $check = $this->checkStock($item);
            if(!$check)
            {
                return ['error' => 'order has item out-stock'];
            }
            $itemPrice = $this->calculateItemPriceBasedOnQty($item->product_attribute_value_id, $item->qty, $user->type);
            //if discount 0 update  total discount
            if(!$itemPrice['discount'])
            {
                $data['discount'] = 0;
            }

            $items[] = new OrderItem([
                'product_attribute_value_id' => $item->product_attribute_value_id,
                'unit_price' => $itemPrice['base_price'],
                'discounted_price' => $itemPrice['discount'],
                'qty' => $item->qty,
                'print_image'    => $item->print_image ?? '',
            ]);

            if(!$itemPrice || empty($itemPrice)){
                return ['error' => 'prices not set correctly please contact Admin!'];
            }
            $itemsSubTotal += $itemPrice['base_price'] * $item->qty;

            $emailConfirmationData['items'][] = [
                'name' => $item->item_name . '('.$item->color_name.')',
                'image' => $item->item_image,
                'print_image'    => $item->print_image ?? '',
                'unit_price' => $itemPrice['base_price'],
                'qty' => $item->qty,
                'total_price'   => $item->qty * $itemPrice['base_price']
            ];
        }
        $emailConfirmationData['discount'] = $data['discount'];
        $emailConfirmationData['delivery'] = $data['delivery'];
        $emailConfirmationData['subtotal'] = $itemsSubTotal;
        $emailConfirmationData['total'] = ($itemsSubTotal - $data['discount'] + $data['delivery']);
        $emailConfirmationData['order_code'] = $order->order_code;
        $emailConfirmationData['order_date'] = $order->created_at;
        $emailConfirmationData['payment_method'] = $order->payment_method;
        $emailConfirmationData['email'] = $user->email;
        $saveItems = $order->orderItems()->saveMany($items);

        $order->update([
            'total_discount' => $data['discount'],
            'sub_total' => $itemsSubTotal,
            'total' => ($itemsSubTotal - $data['discount'] + $data['delivery']),
        ]);
        if($saveItems)
        {
            $settings = Setting::find(1);
            $this->updateStock($cart->cartItems);
            $this->deleteCart($cart);
            Mail::to( $user->email )->send( new OrderConfirmation( $emailConfirmationData ) );
            Mail::to( $settings->email )->send( new OrderConfirmation( $emailConfirmationData ) );
            return $order;
        }

        return false;
    }

    public function calculateItemPriceBasedOnQty($productAttributeId, $itemQty,  $userType)
    {
        $productAttribute = ProductAttributeValue::find($productAttributeId);
        $product = Product::with( 'prices' )
            ->where( 'id', $productAttribute->product->id )
            ->first();

        //load prices
        $basePrice = [];

        $discountEnabled = Setting::find(1);
        $checkDiscountEnabled = $discountEnabled->enable_offers_page;
        foreach ($product->prices as $price)
        {
            if ( $userType == User::TYPE_USER )
            {
                if(!$checkDiscountEnabled)
                {
                    if($itemQty >= $price->max_qty)
                    {
                        $basePrice['base_price'] = $price->individual_unit_price;
                        $basePrice['discount'] = 0;
                    }
                }
                else
                {
                    if($itemQty >= $price->max_qty)
                    {
                        $basePrice['base_price'] = $price->individual_unit_price;
                        $basePrice['discount'] = $price->individual_discounted_unit_price;
                    }
                }

            }

            if ( $userType == User::TYPE_CORPORATE )
            {

                if(!$checkDiscountEnabled)
                {
                    if($itemQty >= $price->max_qty)
                    {
                        $basePrice['base_price'] = $price->corporate_unit_price;
                        $basePrice['discount'] = 0;
                    }
                }
                else
                {
                    if($itemQty >= $price->max_qty)
                    {
                        $basePrice['base_price'] = $price->corporate_unit_price;
                        $basePrice['discount'] = $price->corporate_discounted_unit_price;
                    }
                }

            }
        }

        return $basePrice ;
    }

    protected function deleteCart($userCart)
    {
        $cart = Cart::find($userCart->id);
        $cartItems = CartItem::where('cart_id', $cart->id)->delete();
        $cart->delete();
    }

    protected function checkStock($item)
    {
        $productAttribute = ProductAttributeValue::find($item->product_attribute_value_id);
        if ( $productAttribute->is_active AND $productAttribute->product->is_active AND $productAttribute->stock >= $item->qty)
        {
            return true;
        }

        return false;
    }

    protected function updateStock($items)
    {
        foreach($items as $item)
        {
            $productAttribute = ProductAttributeValue::find($item->product_attribute_value_id);
            $productAttribute->update([
                'stock' => $productAttribute->stock - $item->qty
            ]);
        }
    }

    public function getUserOrder($user, $orderCode)
    {
        $order = Self::with('orderItems')->where('user_id', $user->id)
                ->where('order_code', $orderCode)->first();

        return $order;
    }
}
