<?php

namespace App\Http\Controllers;

use App\Services\EmployeeVacationService;
use Illuminate\Http\Request;
use App\Models\LeaveCategory;
use Exception;

class LeaveCategoryController extends Controller
{
    protected $vacationService;

    public function __construct(EmployeeVacationService $vacationService)
    {
        $this->vacationService = $vacationService;
    }

    public function show($id)
    {
        $employee = LeaveCategory::find($id);
        $remainingDays = $this->vacationService->getRemainingDays($employee);
        $carryOverDays = $this->vacationService->getCarryOverDays($employee);

        return response()->json( [
            'status'  => 'success',
            'employee' => $employee,
            'remainingDays' => $remainingDays,
            'carryOverDays' => $carryOverDays,
        ], status: 200 );
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leaveCategories = LeaveCategory::all();
        return response()->json( $leaveCategories );
    }

    public function leaveCategoryPage()
    {
        // return view('pages.leaveCategories.index');
        return view('pages.dashboard.leaveCategory-page');
    }

    public function ReqById(Request $request)
    {
        try {
            $leaveCategory_id = $request->input( 'id' );
            $leaveCategory =LeaveCategory::where( 'id', '=', $leaveCategory_id )->first();

            return $leaveCategory;
        }
        catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'Failed',
                'message' => $e->getMessage(),
            ], status: 200 );
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeLeaveCategory(Request $request)
    {
        try {
            $validatedData = $request->validate( [
                'categoryName' => 'required|unique:leave_categories|max:255',
                'description' => 'required|string',
                'available_leaves' => 'required|integer',
            ] );

            // Create new leaveCategory record
            $leaveCategory = LeaveCategory::create( $validatedData );

            return response()->json( [
                'status'  => 'success',
                'message' => 'LeaveCategory recorded successfully',
                'leaveCategory'  => $leaveCategory,
            ] );
        } catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'Failed',
                // 'message' => 'LeaveCategory recorded failed',
                'message' => $e->getMessage(),
            ], status: 200 );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateLeaveCategory(Request $request)
    {
        try {
            $leaveCategory_id = $request->input('id');
            $validatedData = $request->validate([
                'description' => 'required|string',
                'default_days' => 'required|integer',
            ]);

            $leaveCategory = LeaveCategory::where( 'id', $leaveCategory_id )->first();

            if ( !$leaveCategory ) {
                return response()->json( [
                    'status'  => 'Failed',
                    'message' => 'LeaveCategory not found',
                ], status: 200 );
            }

            $leaveCategory->update( $validatedData );

            return response()->json( [
                'status'  => 'success',
                'message' => 'LeaveCategory updated Successfully',
                'leaveCategory'    => $leaveCategory,
            ], status: 200 );
        }
        catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'Failed',
                'message' => $e->getMessage(),
            ] );
        }
    }
    
    public function deleteLeaveCategory(Request $request)
    {
        $leaveCategory_id = $request->input( 'id' );

        $leaveCategory = LeaveCategory::where( 'id', $leaveCategory_id )->delete();

        // return $leaveCategory;

        if ($leaveCategory ) {
            return response()->json( [
                'message' => 'LeaveCategory deleted successfully'
            ], status: 200 );
        }
        else{
            return response()->json( [
                'message' => 'LeaveCategory not found',
            ], status: 200 );
        }
    }
}
