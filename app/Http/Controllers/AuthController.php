<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller {

    /**
     * Create user
     *
     * @param Request $request
     * @return JsonResponse [string] message
     */
    public function register( Request $request )
    {
        $validator = Validator::make( $request->all(), [
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'phone'      => 'required|string',
            'email'      => 'required|string|email|unique:users',
            'password'   => 'required|string|confirmed'
        ] );

        if ( $validator->fails() )
        {
            return response()->json( [
                'message' => $validator->messages()->first(),
            ], 422 );
        }

        $user = new User( [
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'phone'      => $request->phone,
            'email'      => $request->email,
            'password'   => bcrypt( $request->password )
        ] );

        $user->save();

        return response()->json( [
            'message' => 'Successfully created user!'
        ], 201 );
    }

    /**
     * Create Corporate account
     *
     * @param Request $request
     * @return JsonResponse [string] file
     */
    public function registerCorporate( Request $request )
    {
        $validator = Validator::make( $request->all(), [
            'company'      => 'required|string',
            'email'        => 'required|string|email|unique:users',
            'password'     => 'required|string|confirmed',
            'contact'      => 'required|string',
            'job_title'    => 'required|string',
            'phone'        => 'required|string',
        ] );

        if ( $validator->fails() )
        {
            return response()->json( [
                'message' => $validator->messages()->first(),
            ], 422 );
        }

        $user = new User( [
            'company'        => $request->company,
            'contact_person' => $request->contact,
            'job_title'      => $request->job_title,
            'phone'          => $request->phone,
            'email'          => $request->email,
            'is_active'      => '0',
            'type'           => User::TYPE_CORPORATE,
            'is_subscribed'  => $request->subscription ?? 0,
            'password'       => bcrypt( $request->password )
        ] );

        $user->save();

        return response()->json( [
            'message' => 'Successfully created Corporate account!'
        ], 201 );
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login( Request $request )
    {
        $request->validate( [
            'email'       => 'required|string|email',
            'password'    => 'required|string',
            'remember_me' => 'boolean'
        ] );

        $credentials = request( ['email', 'password'] );
        if ( !Auth::attempt( $credentials ) )
            return response()->json( [
                'message' => 'Unauthorized'
            ], 401 );

        if($request->user()->is_active)
        {
            $user = $request->user();
            $tokenResult = $user->createToken( 'Personal Access Token' );
            $token = $tokenResult->token;

            if ( $request->remember_me )
            {
                $token->expires_at = Carbon::now()->addWeeks( 4 );
            }

            $token->save();

            return response()->json( [
                'access_token' => $tokenResult->accessToken,
                'token_type'   => 'Bearer',
                'expires_at'   => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ] );
        }

        return response()->json( [
            'message' => 'Your account is not active yet!'
        ], 422 );

    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout( Request $request )
    {
        $request->user()->token()->revoke();

        return response()->json( [
            'message' => 'Successfully logged out'
        ] );
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user( Request $request )
    {
        return response()->json( $request->user() );
    }
}
