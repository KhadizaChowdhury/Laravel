<?php

namespace App\Http\Controllers;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboardPage()
    {
        return view('layouts.dashboard');
    }

    public function ProfilePage()
    {
        return view('pages.profile.index');
    }

    public function ProfileUpdatePage()
    {
        return view('pages.profile.profileForm');
    }

    public function UserProfile( Request $request ) {
        try {
            $email = $request->header( 'email' );
            $user = User::where( 'email', '=', $email )->first();

            return response()->json( [
                'status'  => 'success',
                'message' => 'UserProfile found Successfully',
                'data'    => $user,
            ], status: 200 );
        } catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'Failed',
                'message' => 'UserProfile not Found',
                // 'message' => $e->getMessage(),
            ], status: 200 );
        }

    }

    public function UpdateUser( Request $request ) {
        try {
            $email = $request->header( 'email' );
            $firstName = $request->input( 'firstName' );
            $lastName  = $request->input( 'lastName' );
            $mobile    = $request->input( 'mobile' );
            $password  = $request->input( 'password' );
            $user = User::where( 'email', '=', $email )->update( [
                'firstName' => $firstName,
                'lastName'  => $lastName,
                'mobile'    => $mobile,
                'password'  => $password,
            ] );

            return response()->json( [
                'status'  => 'success',
                'message' => 'User Updated Successfully',
                'data'    => $user,
            ], status: 200 );
        }
        catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'Failed',
                // 'message' => 'User update failed',
                'message' => $e->getMessage(),
            ] );
        }
    }
}
