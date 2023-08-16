<?php

namespace App\Http\Controllers;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboardPage(Request $request)
    {
        return view( 'pages.dashboard.event-page' );
    }

    public function ProfilePage()
    {
        return view('pages.dashboard.profile-page');
    }

    public function ProfileUpdatePage()
    {
        return view('pages.dashboard.profileForm-page');
    }

    public function userProfileDetails($id)
    {
        $user = User::find($id);
        if ( $user ) {
            return view('pages.profile.userProfileDetails' , ['user' => $user]);
        }
        else{
            return response()->json( ['message' => 'User not found'], 404 );
        }
    }

    public function allUser()
    {
        $users = User::all();
        return response()->json( $users );
    }

    public function userDetails(string $id)
    {
        try {
            $user = User::where( 'id', '=', $id )->first();

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
