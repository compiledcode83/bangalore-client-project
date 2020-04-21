<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAddressRequest;
use App\Models\Area;
use App\Models\DeliveryCharge;
use App\Models\Governorate;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressesController extends Controller {

    public function getUserAddresses()
    {
        $user = Auth::user();
        $governorates = Governorate::active()->with( 'areas' )->get();
        $defaultShipping = UserAddress::where( 'user_id', $user->id )
            ->where( 'is_default_shipping', '1' )
            ->first();
        $defaultShipping = $this->addGovAreaName($defaultShipping);

        $defaultBilling = UserAddress::where( 'user_id', $user->id )
            ->where( 'is_default_billing', '1' )
            ->first();
        $defaultBilling = $this->addGovAreaName($defaultBilling);

        $allAddresses  = UserAddress::where( 'user_id', $user->id )
            ->where( 'is_default_shipping', '0' )
            ->where( 'is_default_billing', '0' )
            ->get();

        $allAddresses = $this->addGovAreaName($allAddresses, 'array');

        return [
            'addresses'       => $allAddresses,
            'defaultBilling'  => $defaultBilling,
            'defaultShipping' => $defaultShipping,
            'user_type'       => $user->type,
            'governorates'    => $governorates,
        ];
    }

    public function addGovAreaName($addresses, $isArray = null)
    {
        if($isArray)
        {
            foreach ($addresses as $address)
            {

                $gov = Governorate::find( $address->governorate );
                if ( isset( $gov->name_en ) )
                {
                    $address->governorateName = $gov->name_en;
                }

                $area = Area::find( $address->area );
                if ( isset( $area->name_en ) )
                {
                    $address->areaName = $area->name_en;
                }
            }
        }
        else
        {
            if(isset($addresses->governorate))
            {
                $gov = Governorate::find( $addresses->governorate );
                if ( isset( $gov->name_en ) )
                {
                    $addresses->governorateName = $gov->name_en;
                }
            }


            if(isset($addresses->area))
            {
                $area = Area::find( $addresses->area );
                if ( isset( $area->name_en ) )
                {
                    $addresses->areaName = $area->name_en;
                }
            }

        }

        return $addresses;
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
            'officeAddress', 'officeNo', 'defaultShipping', 'defaultBilling', 'id','house');

        if(isset($attributes['id']))
        {
            //only update it
            return $this->update($request);
        }

        $user = Auth::user();

        if(isset($attributes['defaultShipping'])){
            UserAddress::where('user_id', $user->id)->update(['is_default_shipping' => 0]);
        }

        if(isset($attributes['defaultBilling'])){
            UserAddress::where('user_id', $user->id)->update(['is_default_billing' => 0]);
        }

        $addressFields = [
            'user_id'             => $user->id,
            'is_default_shipping' => $attributes['defaultShipping'] ?? 0,
            'is_default_billing'  => $attributes['defaultBilling'] ?? 0,
            'governorate'         => $attributes['governorate'],
            'area'                => $attributes['area'],
            'block'               => $attributes['block'],
            'street'              => $attributes['street'],
            'building'            => $attributes['building'],
            'floor'               => $attributes['floorNo'] ?? '',
            'house_number'        => $attributes['house'] ?? '',
            'office_number'       => $attributes['officeNo'] ?? '',
            'office_address'      => $attributes['officeAddress'] ?? '',
        ];

        return UserAddress::create( $addressFields );
    }

    public function update( CreateAddressRequest $request )
    {
        $attributes = $request->only(
            'governorate', 'area', 'block', 'street', 'building', 'floorNo',
            'officeAddress', 'officeNo', 'defaultShipping', 'defaultBilling', 'id', 'house' );

        $user = Auth::user();

        if(isset($attributes['defaultShipping']) AND $attributes['defaultShipping'] == '1'){
            UserAddress::where('user_id', $user->id)->update(['is_default_shipping' => 0]);
        }

        if(isset($attributes['defaultBilling']) AND $attributes['defaultBilling'] == '1'){
            UserAddress::where('user_id', $user->id)->update(['is_default_billing' => 0]);
        }

        $addressFields = [
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

        $address = UserAddress::find($attributes['id']);
        if($address)
        {
            $address->update($addressFields);
            return 1;
        }

        return 0;
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

    public function deleteAddress(Request $request)
    {
        $user = Auth::user();
        $attribute = $request->only('id');
        $address = UserAddress::where('id',$attribute['id'])->where('user_id', $user->id)->first();
        if($address)
        {
            $address->delete();
            return 1;
        }

        return 0;
    }
}
