<?php

namespace App\Http\Controllers;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboardPage(Request $request)
    {
        return view( 'pages.dashboard.leaveCategory-page' );
    }

    public function ProfilePage()
    {
        return view('pages.dashboard.profile-page');
    }

    public function ProfileUpdatePage()
    {
        return view('pages.dashboard.profileForm-page');
    }

    public function userProfileDetails(Request $request, $id)
    {
        $user_id = $request->header( 'u_id' );
        $user_c = User::find( $user_id );
        $user = User::find( $id );

        // Ensure we've found the user in the database
        if ( !$user ) {
            return response()->json( [
                'message' => 'User not found',
            ], 404 );
        }

        // Check if the user from the header has a role of 1 OR if the fetched user's ID matches the ID from the header
        if (  ( $user_c && $user_c->role == 1 ) || $user->id == $user_id ) {
            return view( 'pages.profile.profileDetails', ['user' => $user] );
        } else {
            return response()->json( [
                'message' => 'Access denied',
            ], 403 ); // 403 Forbidden would be a more appropriate status code for unauthorized access
        }
    }

    //Backend Api
    public function userList()
    {
        try {
            $users = User::all();
            return response()->json( $users );
        }
        catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'Failed',
                'message' => $e->getMessage(),
            ], status: 200 );
        }
    }

    public function ReqById(Request $request)
    {
        try {
            $user_id = $request->input( 'id' );
            $user = User::where( 'id', '=', $user_id )->first();

            return $user;
        }
        catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'Failed',
                'message' => $e->getMessage(),
            ], status: 200 );
        }
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

    public function UpdateUserProfile( Request $request ) {

        try {
            $email = $request->header( 'email' );
            $validatedData = $request->validate( [
                'firstName'  => 'required|string',
                'lastName'  => 'required|string',
                'mobile' => 'required|integer',
            ] );

            $user = User::where( 'email', $email )->first();

            if ( !$user ) {
                return response()->json( [
                    'status'  => 'Failed',
                    'message' => 'user not found',
                ], status: 200 );
            }

            $user->update( $validatedData );

            return response()->json( [
                'status'        => 'success',
                'message'       => 'user updated Successfully',
                'user' => $user,
            ], status: 200 );
        } catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'Failed',
                'message' => $e->getMessage(),
            ] );
        }
    }
    
    public function UpdateUser( Request $request ) {
        try {
            $user_id = $request->input( 'id' );
            $validatedData = $request->validate( [
                'firstName'  => 'required|string',
                'lastName'  => 'required|string',
                'mobile' => 'required|integer',
            ] );

            $user = User::where( 'id', $user_id )->first();

            if ( !$user ) {
                return response()->json( [
                    'status'  => 'Failed',
                    'message' => 'user not found',
                ], status: 200 );
            }

            $user->update( $validatedData );

            return response()->json( [
                'status'        => 'success',
                'message'       => 'user updated Successfully',
                'user' => $user,
            ], status: 200 );
        } catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'Failed',
                'message' => $e->getMessage(),
            ] );
        }
    }

    public function delete(Request $request)
    {
        try{
            $user_id = $request->input( 'id' );

            $user = User::where( 'id', $user_id )->delete();

            // return $user;
            if ($user ) {
                return response()->json( [
                    'status'        => 'success',
                    'message' => 'user deleted successfully',
                    'user' => $user,
                ], status: 200 );
            }
            else{
                return response()->json( [
                    'message' => 'user not found',
                ], status: 200 );
            }
        }
        catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'Failed',
                'message' => $e->getMessage(),
            ] );
        }
    }
}
