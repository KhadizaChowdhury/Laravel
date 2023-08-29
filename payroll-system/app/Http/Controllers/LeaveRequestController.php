<?php

namespace App\Http\Controllers;

use App\Mail\leaveReqMail;
use App\Mail\leaveStatusMail;
use App\Models\LeaveCategory;
use App\Models\LeaveReport;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Exception;

class LeaveRequestController extends Controller
{
    public function index()
    {
        try{
            $leaveRequests = LeaveRequest::with([
                    'user' => function($query) {
                        $query->select('id','firstName', 'lastName');
                    }
                ])->get();
            return response()->json($leaveRequests);
        }
        catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'Failed',
                'message' => $e->getMessage(),
            ], status: 200 );
        }
    }

    public function leaveRequestPage()
    {
        // return view('pages.leaveCategories.index');
        return view('pages.dashboard.leaveRequest-page');
    }public function createPage()
    {
        // return view('pages.leaveCategories.index');
        return view('pages.dashboard.employee.leaveRequest-page');
    }

    public function ReqById(Request $request)
    {
        try {
            $leaveRequest_id = $request->input( 'id' );

            $leaveRequest =LeaveRequest::where( 'id', '=', $leaveRequest_id )->first();

            return $leaveRequest;
        }
        catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'Failed',
                'message' => $e->getMessage(),
            ], status: 200 );
        }
    }

    public function getAll()
    {
        $categories = LeaveCategory::all();
        return response()->json($categories);
    }


    public function store(Request $request)
    {
        try{
            // Validate the request data
            $validatedData = $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'leave_category_id' => 'required',
                'reason' => 'required|string',
                // ... add other fields and their validation rules
            ]);

            $user_id = $request->header( 'u_id' );
            // Fetch the LeaveCategory based on the reason (name)
            $leaveCategory = LeaveCategory::where( 'id', $validatedData['leave_category_id'] )->first();

            $user = User::findOrFail( $user_id );

            // Calculate number_of_days based on start_date and end_date
            $startDate = Carbon::parse( $validatedData['start_date'] );
            $endDate = Carbon::parse( $validatedData['end_date'] );
            $number_of_days = $startDate->diffInDays( $endDate ) + 1;

            // Merge user_id and leave_category_id into validatedData
            $validatedData = array_merge( $validatedData, [
                'user_id' => $user_id,
                'number_of_days' => $number_of_days,
                ] );

            // Create new leaveRequest record
            $leaveRequest = LeaveRequest::create( $validatedData );
            $leaveRequest->load( 'user' );
            $leaveReq = $leaveRequest;
            $report = LeaveReport::firstOrCreate( [
                'user_id' => $leaveRequest->user_id,
            ] );

            $manager = User::where( 'role', 1 )->first();
            $email = $manager->email;
            //leaveReq Mail Address
            // Mail::to( $email )->send( new leaveReqMail( $leaveReq ) );
            Mail::to( $email )->queue( new leaveReqMail( $leaveReq ) );

            return response()->json( [
                'status'  => 'success',
                'message' => 'Leave request created successfully',
                'data'    => $leaveRequest,
            ], 201 );
        }
        catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'Failed',
                'message' => $e->getMessage(),
            ], status: 200 );
        }
    }

    public function update(Request $request)
    {
        try {
            $leaveRequest_id = $request->input('id');

            // Validate the request data
            $validatedData = $request->validate([
                'start_date' => 'date',
                'end_date' => 'date',
                'leave_category_id' => 'string',
                'reason' => 'string',
                'status' => 'string',
            ]);

            $approved_by = $request->header('u_id');
                    
            $leaveRequest = LeaveRequest::with([
                    'user' => function($query) {
                        $query->select('id','firstName', 'lastName');  // Replace 'id', 'name' with the columns you need
                    },
                    'leaveCategory' => function($query) {
                        $query->select('id', 'categoryName', 'available_leaves');  // Replace 'id', 'category_name' with the columns you need
                    },
                ])
                ->where('id', $leaveRequest_id)
                ->first();
            
            
            if ( !$leaveRequest ) {
                return response()->json( [
                    'status'       => 'Failed',
                    'leaveRequest' => $leaveRequest,
                    'message'      => 'LeaveRequest not found',
                ], 200 );
            }
            $leaveRequest->update( $validatedData );

            // If start_date or end_date are updated, then recalculate number_of_days
            if ( isset( $leaveRequest['start_date'] ) && isset( $leaveRequest['end_date'] ) ) {
                $startDate = Carbon::parse( $leaveRequest['start_date'] );
                $endDate = Carbon::parse( $leaveRequest['end_date'] );
                $daysRequested = $startDate->diffInDays( $endDate ) + 1;
                $leaveRequest['number_of_days'] = $daysRequested;
                $leaveRequest->save();
            }

            // Fetch the user instance associated with the leave request
            $user = User::find( $leaveRequest['user_id'] );

            $leaveReport = LeaveReport::firstOrCreate( [
                'user_id'           => $leaveRequest['user_id'],
            ] );

            if ( isset( $daysRequested ) ) {
                if ( $leaveRequest['leave_category_id']==1 &&($leaveReport->vacation_leaves_taken + $daysRequested) > 15 ) {
                    return response()->json( [
                        'status'  => 'Denied',
                        'message' => 'Vacation leaves fulfilled',
                    ], 200 );
                }
                else if ( $leaveRequest['leave_category_id']==3 &&($leaveReport->unpaid_leaves_taken  + $daysRequested) > 30 ) {
                    return response()->json( [
                        'status'  => 'Denied',
                        'message' => 'Unpaid leaves fulfilled',
                    ], 200 );
                }
                else if ( $leaveRequest['leave_category_id']==2 &&($leaveReport->sick_leaves_taken  + $daysRequested) > 10 ) {
                    return response()->json( [
                        'status'  => 'Denied',
                        'message' => 'Sick leaves fulfilled',
                    ], 200 );
                }
            } 
            
            $leaveRequest['approved_at'] = Carbon::now();
            $leaveRequest['status'] = "Approved";
            $leaveRequest->save();
            // Deduct the leave days
            $leaveReport->increment( 'total_leaves_taken', $daysRequested );

            // Save the changes to the database
            switch ( $leaveRequest['leave_category_id'] ) {
            case '1':
                $leaveReport->vacation_leaves_taken += $daysRequested;
                break;
            case '2':
                $leaveReport->sick_leaves_taken += $daysRequested;
                break;
            case '3':
                $leaveReport->unpaid_leaves_taken += $daysRequested;
                break;
                // ... add more cases as per your categories
            }
            

            // Fetch the user instance associated with the leave request
                $user = User::find( $leaveRequest['user_id'] );
                
                // After updating with leaveRequest, set the approved_by
                $leaveRequest['approved_by'] = $approved_by;
                $validatedData = array_merge( $validatedData, [
                    'status'      => "Approved",
                    'approved_by' => $approved_by,
                ] );
                $leaveRequest->update( $validatedData );
                // Set approved_by attribute
                $leaveReport->approved_by = $leaveRequest['approved_by'];
                $leaveReport->save();

                $email = $user->email;
                //leaveReq Mail Address
                // Mail::to( $email )->send( new leaveStatusMail( $leaveRequest ) );
                Mail::to( $email )->queue( new leaveStatusMail( $leaveRequest ) );

                $leaveRequest = LeaveRequest::with([
                    'leaveCategory' => function($query) {
                        $query->select('id', 'categoryName', 'available_leaves');  // Replace 'id', 'category_name' with the columns you need
                    },
                ])->find( $leaveRequest['id'] );
                $leaveRequest->save();

                return response()->json( [
                    'status'  => 'Success',
                    'message' => 'LeaveRequest updated successfully',
                    'data'    => $leaveRequest,
                ], 200 );

        }
        catch (Exception $e) {
            return response()->json([
                'status' => 'Error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function delete(Request $request)
    {
        $LeaveRequest_id = $request->input( 'id' );
        $user_id = $request->header( 'u_id' );

        $leaveRequest = LeaveRequest::where( 'id', $LeaveRequest_id )->where('user_id',$user_id)->delete();

        // return $leaveRequest;

        if ($leaveRequest ) {
            return response()->json( [
                'message' => 'LeaveRequest deleted successfully'
            ], status: 200 );
        }
        else{
            return response()->json( [
                'message' => 'LeaveRequest not found',
            ], status: 200 );
        }
    }
}
