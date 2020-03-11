<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsletterController extends Controller
{
    public function getUserSubscription()
    {
        $user = Auth::user();

        return $user->is_subscribed;
    }

    public function updateSubscription(Request $request)
    {
        $user = Auth::user();
        $attribute = $request->only('newsletter');

        $findUser = User::find($user->id);
        $findUser->update(['is_subscribed' => $attribute['newsletter']]);

        return $findUser->is_subscribed;
    }
}
