<?php

namespace App\Http\Controllers;

use App\Mail\RegistrationWelcome;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class AuthController extends Controller {

    use ResetsPasswords, SendsPasswordResetEmails;

    /**
     * Create user
     *
     * @param Request $request
     * @return JsonResponse [string] message
     */
    public function register( Request $request )
    {
        $validator = Validator::make( $request->all(), [
            'email'      => 'required|string|email|unique:users',
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'phone'      => 'required|string',
            'password'   => 'required|string|confirmed'
        ] );

        if ( $validator->fails() )
        {
            return response()->json( [
                'message' => $validator->messages()->first(),
            ], 422 );
        }

        $user = new User( [
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'phone'         => $request->phone,
            'email'         => $request->email,
            'is_subscribed' => $request->newsLetter ? 1 : 0,
            'password'      => bcrypt( $request->password )
        ] );

        $user->save();

        Mail::to($request->email)->queue(new RegistrationWelcome());

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
            'company'         => 'required|string',
            'email'           => 'required|string|email|unique:users',
            'password'        => 'required|string|confirmed',
            'contact'         => 'required|string',
            'job_title'       => 'required|string',
            'company_license' => 'required|mimetypes:application/pdf|max:1000',
            'phone'           => 'required|string',
        ] );

        if ( $validator->fails() )
        {
            return response()->json( [
                'message' => $validator->messages()->first(),
            ], 422 );
        }

        $filePdfName = '';
        if ( $request->hasFile( 'company_license' ) )
        {
            $file = $request->file( 'company_license' );
            //save image
            $fileName = Str::random( 15 );
            $filePdfName = $fileName . '.pdf';
            $file->move( 'uploads/corporates', $filePdfName );
        }

        $user = new User( [
            'company'         => $request->company,
            'contact_person'  => $request->contact,
            'job_title'       => $request->job_title,
            'phone'           => $request->phone,
            'email'           => $request->email,
            'is_active'       => '0',
            'company_license' => $filePdfName,
            'type'            => User::TYPE_CORPORATE,
            'is_subscribed'   => $request->newsLetter ? 1 : 0,
            'password'        => bcrypt( $request->password )
        ] );

        $user->save();

        Mail::to($request->email)->queue(new RegistrationWelcome());

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
        {
            return response()->json( [
                'message' => 'Unauthorized'
            ], 401 );
        }

        if ( $request->user()->is_active )
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

    /**
     * Send password reset link.
     */
    public function sendPasswordResetLink( Request $request )
    {
        return $this->sendResetLinkEmail( $request );
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse( Request $request, $response )
    {
        return response()->json( [
            'message' => 'Password reset email sent.',
            'data'    => $response
        ] );
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkFailedResponse( Request $request, $response )
    {
        return response()->json( ['message' => 'Email could not be sent ... please check entered email again!'] );
    }

    /**
     * Handle reset password
     */
    public function callResetPassword( Request $request )
    {
        $attributes = $request->all();
        $email = '';
        $resets = DB::table( 'password_resets' )->get();
        foreach ($resets as $reset)
        {
            if ( Hash::check( $attributes['token'], $reset->token ) )
            {
                $email = $reset->email;
            }
        }

        if ( $email === '' )
        {
            return response()->json( ['error' => 'Invalid Token ... please request  another email!'] );
        }
        $request->request->add( ['email' => $email] );

        return $this->reset( $request );
    }

    /**
     * Get the password reset credentials from the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function credentials( Request $request )
    {
        return $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
    }

    /**
     * Reset the given user's password.
     *
     * @param \Illuminate\Contracts\Auth\CanResetPassword $user
     * @param string                                      $password
     * @return void
     */
    protected function resetPassword( $user, $password )
    {
//        dd($user);
        $user->password = Hash::make( $password );
        $user->save();
        event( new PasswordReset( $user ) );

    }

    protected function sendResetResponse( Request $request, $response )
    {
        return response()->json( ['success' => 'Password reset successfully.'] );
    }

    /**
     * Get the response for a failed password reset.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetFailedResponse( Request $request, $response )
    {
        return response()->json( ['message' => 'Failed, Invalid Token.'] );

    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }
}
