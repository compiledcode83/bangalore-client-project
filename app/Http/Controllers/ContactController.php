<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function getInformations()
    {
        $settings = Setting::find(1)->get( ['contact_img','email','fax','tel','lng','lat','building_en','street_en','area_en','city_en','cantry_en'] );

        return ['informations' => $settings];

    }

    public function sentMail(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'mobile' => ['required', 'string','max:255'],
            'subject' => ['required', 'string'],
            'message' => ['required'],
        ]);


        if($valid->fails()){

            return ['errors' => $valid];
        }

        if($valid->validate()){
            $settings = Setting::find(1)->get( ['email']);
            return ['message' => 'Email sent'];
        }
        return ['error' => 'Server Error'];
    }
}
