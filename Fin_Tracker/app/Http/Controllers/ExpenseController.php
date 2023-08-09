<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Expense;
use Exception;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        // $expenses = Expense::paginate(10);
        // $expenses = Expense::with( 'user' )->paginate(10);
        // return view('expenses.index', compact('expenses'));
        $expenses = Expense::all();
        // $expenses = Expense::with( 'user' )->get();
        return response()->json( $expenses );
    }

    public function expensePage()
    {
        return view('pages.expenses.index');
    }

    public function ReqById(Request $request)
    {
        $user_id = $request->header( 'u_id' );
        $expense = Expense::where('user_id', $user_id)
        ->with( 'user' )->get();
        return response()->json( $expense );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeExpense(Request $request)
    {
        $validatedData = $request->validate([
            'amount' => 'required|numeric',
            'description' => 'required|string|max:255',
            'category'    => 'required|string|max:255',
            'date'        => 'required|date',
        ]);

        // Fetch user_id from header
        $user_id = $request->header( 'u_id' );

        // Merge user_id into validatedData
        $validatedData = array_merge( $validatedData, ['user_id' => $user_id] );

        $expense = Expense::create($validatedData);

        return response()->json(['message' => 'Expense recorded successfully', 'expense' => $expense]);
    }

    public function updateExpense(Request $request)
    {
        try {
                $validatedData = $request->validate([
                'description' => 'required|string|max:255',
                'amount'      => 'required|numeric',
                'date'        => 'required|date',
                'category'    => 'required|string|max:255',
            ]);

            $user_id = $request->header('u_id');
            $expense_id = $request->header('id');

            // Ensure the authenticated user is updating their own income record
            $expense = Expense::where('user_id', $user_id)->where('id', $expense_id)->first();

            if (!$expense) {
                return response()->json([
                    'status'  => 'Failed',
                    'message' => 'Expense not found',
                ], status: 404);
            }

            $expense->update($validatedData);


            return response()->json( [
                'status'  => 'success',
                'message' => 'Expense updated Successfully',
                'income'    => $expense,
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    public function deleteExpense(Expense $expense)
    {
        $expense->delete();

        if ( $expense ) {
            return response()->json( ['message' => 'Expense deleted successfully'], status: 200 );
        } else {
            return response()->json( [
                'message' => 'Income not found',
            ], status: 200 );
        }
    }
}
