<?php

namespace App\Http\Controllers;

use App\Models\LeaveReport;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use PDF;

class LeaveReportController extends Controller
{

    public function ReportPage(){
        return view('pages.dashboard.report-page');
    }

    public function index()
    {
        try{
            $LeaveReports = LeaveReport::with([
                    'user' => function($query) {
                        $query->select('id','firstName', 'lastName','email');
                    }
                ])->get();

            return response()->json($LeaveReports);
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
            $report_id = $request->input( 'id' );
            $report = LeaveReport::where( 'user_id', $report_id )->first();
            $leaveRequest = LeaveRequest::where( 'user_id', $report_id )->get();

            return response()->json( [
                'status'  => 'success',
                'message' => 'Leave request created successfully',
                'report'    => $report,
                'leaveRequest'    => $leaveRequest,
            ], 201 );
        }
        catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'Failed',
                'message' => $e->getMessage(),
            ], status: 200 );
        }
    }

    public function fetchUserReports(Request $request, $userId)
    {
        // Fetch the manager's ID from the request header
        $manager_id = $request->header('u_id');
        $manager = User::find($manager_id);

        // Check if the manager exists and their role is 'Manager' before proceeding
        if ($manager && $manager->role != 1 ) {// Assuming '1' is the role for managers
            return response()->json(['error' => 'Unauthorized access'], 403);  // 403 Forbidden response
        }

        // Fetch the user and their leave reports
        $user = User::with('leaveReports')->findOrFail($userId);

        $response = [
            'user'    => $user->only(['id', 'firstName', 'lastName', 'email']),
            'reports' => $user['leaveReports'],
        ];

        return response()->json($response);
    }

}
