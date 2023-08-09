<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\User;
use Exception;

class IncomeController extends Controller
{
    public function index()
    {
        
        // $incomes = Income::paginate(10);
        // $incomes = Income::with( 'user' )->paginate(10);
        // return view('incomes.index', compact('incomes'));
        $incomes = Income::all();
        // $incomes = Income::with( 'user' )->get();
        return response()->json( $incomes );
    }

    public function incomePage()
    {
        return view('pages.incomes.index');
    }

    public function ReqById(Request $request)
    {
        $user_id = $request->header( 'u_id' );
        $incomes = Income::where('user_id', $user_id)
        ->with( 'user' )->get();
        return response()->json( $incomes );
    }

    public function create()
    {
        return view('pages.incomes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'category' => 'required'
        ]);

        auth()->user()->incomes()->create($request->all());

        return redirect()->route('incomes.index');
    }

    public function storeIncome(Request $request)
    {
        try {
            $validatedData = $request->validate( [
                'description' => 'required|string|max:255',
                'amount'      => 'required|numeric',
                'date'        => 'required|date',
                'category'    => 'required|string|max:255',
            ] );

            // Fetch user_id from header
            $user_id = $request->header( 'u_id' );

            // Merge user_id into validatedData
            $validatedData = array_merge( $validatedData, ['user_id' => $user_id] );

            // Create new income record
            $income = Income::create( $validatedData );

            return response()->json([
                'status'  => 'success',
                'message' => 'Income recorded successfully',
                'income'    => $income,
            ]);
        }
        catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'Failed',
                // 'message' => 'Income recorded failed',
                'message' => $e->getMessage(),
            ], status: 200 );
        }
    }


    /**
     * Display the specified resource.
     */
    public function showIncome($id)
    {
        try {
            $income = Income::find($id);

            if ($income) {
                return response()->json($income);
            }
        }
        catch ( Exception $e ) {
            return response()->json(['message' => 'Task not found'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateIncome(Request $request)
    {
        try {
                $validatedData = $request->validate([
                'description' => 'required|string|max:255',
                'amount'      => 'required|numeric',
                'date'        => 'required|date',
                'category'    => 'required|string|max:255',
            ]);

            $user_id = $request->header('u_id');
            $income_id = $request->header('id');

            // Ensure the authenticated user is updating their own income record
            $income = Income::where('user_id', $user_id)->where('id', $income_id)->first();

            if (!$income) {
                return response()->json([
                    'status'  => 'Failed',
                    'message' => 'Income not found',
                ], status: 404);
            }

            $income->update($validatedData);


            return response()->json( [
                'status'  => 'success',
                'message' => 'Income updated Successfully',
                'income'    => $income,
            ], status: 200 );

        }
        catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'Failed',
                // 'message' => 'Task not found'], 404 );
                // 'message' => $e->getMessage(),
            ] );
        }
    }

    public function deleteIncome(Income $income)
    {
        $income->delete();

        if ($income ) {
            return response()->json( ['message' => 'Income deleted successfully'], status: 200 );
        }
        else{
            return response()->json( [
                'message' => 'Income not found',
            ], status: 200 );
        }
    }
}
