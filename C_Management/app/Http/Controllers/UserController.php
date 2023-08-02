<?php

namespace App\Http\Controllers;
use App\Helper\JwtToken;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function LogInPage() {
        return view( "pages.auth.login" );
    }

    public function UserRegPage() {
        return view( "pages.auth.signup" );
    }

    public function SendOtpPage() {
        return view( "pages.auth.sendOtp" );
    }

    public function VerifyOtpPage() {
        return view( "pages.auth.verifyOtp" );
    }

    public function ResetPassPage() {
        return view( "pages.auth.resetPassword" );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createUser( Request $request ) {
        try {
            $user = User::create( [
                'firstName' => $request->input( 'firstName' ),
                'lastName'  => $request->input( 'lastName' ),
                'email'     => $request->input( 'email' ),
                'mobile'    => $request->input( 'mobile' ),
                'password'  => $request->input( 'password' ),
            ] );

            return response()->json( [
                'status'  => 'success',
                'message' => 'User Registration Successfully',
            ], status: 200 );
        } catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'Failed',
                // 'message' => 'User Registration failed',
                'message' => $e->getMessage(),
            ] );
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function UserLogin( Request $request ) {
        $email = $request->input( 'email' );
        $password = $request->input( 'password' );

        // $hashedPassword = Hash::make( $password );

        $count = User::where( 'email', '=', $email )->where( 'password', '=', $password )->select( 'id' )->first();
        // $count = User::where( 'email', '=', $email )->where( 'password', '=', $password )->count();

        try {
            $token = JwtToken::CreateToken( $request->input( 'email' ), $count->id );
            // $token = JwtToken::CreateToken( $request->input( 'email' ));
            return response()->json( [
                'status'  => 'success',
                'message' => 'User Login Successfully',
                // 'token' => $token,
            ], status: 200 )->cookie( 'token', $token, 60 * 24 * 30 );
        } catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'Failed',
                'message' => 'User Login failed',
                // 'message' => $e->getMessage(),
            ], status: 200 );
        }
    }

    /**
     * Display the specified resource.
     */
    public function SendOTPCode( Request $request ) {
        $email = $request->input( 'email' );
        $otp = rand( 1000, 9999 );
        $count = User::where( 'email', '=', $email )
            ->count();

        if ( $count == 1 ) {
            //OTP Mail Address
            Mail::to( $email )->send( new OTPMail( $otp ) );
            User::where( 'email', '=', $email )->update( ['otp' => $otp] );
            return response()->json( [
                'status'  => 'success',
                'message' => 'Otp sent',
            ], status: 200 );
        } else {
            return response()->json( [
                'status'  => 'Failed',
                'message' => 'Unauthorized',
            ], status: 200 );
        }
    }
    public function VerifyOTP( Request $request ) {
        $email = $request->input( 'email' );
        $otp = $request->input( 'otp' );
        $count = User::where( 'email', '=', $email )
            ->where( 'otp', '=', $otp )
            ->count();

        if ( $count == 1 ) {
            //Database OTP Update
            User::where( 'email', '=', $email )->update( ['otp' => 0] );

            //Password Reset Token Issue
            $token = JwtToken::CreateTokenForSetPass( $request->input( 'email' ) );
            return response()->json( [
                'status'  => 'success',
                'message' => 'Otp Verification Successful',
                // 'token' => $token,
            ], status: 200 )->cookie( 'token', $token, 60 * 24 * 30 );
        } else {
            return response()->json( [
                'status'  => 'Failed',
                'message' => 'Unauthorized',
            ], status: 200 );
        }
    }

    public function ResetPassword( Request $request ) {
        try {
            $email = $request->header( 'email' );
            $password = $request->input( 'password' );

            // $hashedPassword = Hash::make( $password );

            // User::where( 'email', '=', $email )
            // ->update(['password' => $hashedPassword]);
            User::where( 'email', '=', $email )
                ->update( ['password' => $password] );

            return response()->json( [
                'status'  => 'success',
                'message' => 'Reset Password Successful',
            ], status: 200 );
        } catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'Failed',
                'message' => 'Reset Password failed',
                // 'message' => $e->getMessage(),
            ], status: 200 );
        }

    }

    //Log Out

    public function LogOutPage() {
        return redirect( '/user-login' )->cookie( 'token', '', -1 );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( string $id ) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request, string $id ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( string $id ) {
        //
    }

    public function dashboardPage() {
        return view( 'layouts.dashboard' );
    }
}
