<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAddressRequest;
use App\Models\Area;
use App\Models\DeliveryCharge;
use App\Models\Governorate;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressesController extends Controller {

    public function getUserAddresses()
    {
        $user = Auth::user();
        $governorates = Governorate::with( 'areas' )->get();
        $defaultShipping = UserAddress::where( 'user_id', $user->id )
            ->where( 'is_default_shipping', '1' )
            ->first();

        $defaultBilling = UserAddress::where( 'user_id', $user->id )
            ->where( 'is_default_billing', '1' )
            ->first();

        $allAddresses  = UserAddress::where( 'user_id', $user->id )
            ->where( 'is_default_shipping', null )
            ->where( 'is_default_billing', null )
            ->get();

        return [
            'addresses'       => $allAddresses,
            'defaultBilling'  => $defaultBilling,
            'defaultShipping' => $defaultShipping,
            'user_type'       => $user->type,
            'governorates'    => $governorates,
        ];
    }

    public function getUserAddressesForCheckout()
    {
        $user = Auth::user();
        $addresses = $user->userAddresses;

        foreach ($addresses as $address)
        {
            $gov = Governorate::find( $address->governorate );
            if ( isset( $gov->name_en ) )
            {
                $address->governorate = $gov->name_en;
            }

            $area = Area::find( $address->area );
            if ( isset( $area->name_en ) )
            {
                $address->area = $area->name_en;
            }

            $address->floorNo = $address->floor;
            $address->userType = $user->type;
        }

        return $addresses;
    }

    public function store( CreateAddressRequest $request )
    {
        $attributes = $request->only(
            'governorate', 'area', 'block', 'street', 'building', 'floorNo',
            'officeAddress', 'officeNo', 'defaultShipping', 'defaultBilling' );

        $user = Auth::user();

        $addressFields = [
            'user_id'             => $user->id,
            'is_default_shipping' => $attributes['defaultShipping'] ?? 0,
            'is_default_billing'  => $attributes['defaultBilling'] ?? 0,
            'governorate'         => $attributes['governorate'],
            'area'                => $attributes['area'],
            'block'               => $attributes['block'],
            'street'              => $attributes['street'],
            'building'            => $attributes['building'],
            'floor'               => $attributes['floorNo'],
            'house_number'        => $attributes['house'] ?? '',
            'office_number'       => $attributes['officeNo'] ?? '',
            'office_address'      => $attributes['officeAddress'] ?? '',
        ];

        return UserAddress::create( $addressFields );
    }

    public function getDeliveryChargesForAddress(Request $request)
    {
//        $user = Auth::user();
        $attribute = $request->only('id');
        $address = UserAddress::find($attribute['id']);
        $deliveryCharges = DeliveryCharge::where('area_id', $address->area)->first();
        if($deliveryCharges)
        {
            return $deliveryCharges->charges;
        }
        else
        {
            return 0;
        }
    }
}
