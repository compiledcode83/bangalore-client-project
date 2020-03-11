<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateContactUsRequest;
use App\Mail\ContactUs;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function getInformations()
    {
        $settings = Setting::find(1)->get( ['contact_img','email','fax','tel','lng','lat','building_en','street_en','area_en','city_en','cantry_en'] );

        return ['informations' => $settings];

    }

    public function sentMail(CreateContactUsRequest $request)
    {
        $attributes = $request->only('name', 'email', 'mobile', 'subject', 'message');
        $settings = Setting::find(1)->first();

        Mail::to( $settings->email )->send( new ContactUs( $attributes ) );
        return ['message' => 'Email sent'];
    }
}
