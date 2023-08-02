<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        // return view('tasks.index', compact('tasks'));
        return response()->json( $tasks );
    }
    public function dashboardPage()
    {
        return view('layouts.dashboard');
    }

    public function ProfilePage()
    {
        return view('pages.profile.index');
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $task = new Task;

        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->completed = $request->input('completed');

        $task->save();

        return response()->json(['message' => 'Task created successfully', 'task' => $task]);

        // return redirect()->route( 'tasks.index' )
        // ->with( 'success', 'Task created successfully.' );
    }

    public function show($id)
    {
        $task = Task::find($id);

        // if ( auth()->user()->id !== $task->user_id ) {
        //     return response()->json( ['message' => 'Unauthorized'], 401 );
        // }

        if ($task) {
            return response()->json($task);
            // return view( 'tasks.show', compact( 'task' ) );
        } else {
            return response()->json(['message' => 'Task not found'], 404);
        }
    }


    public function edit(Task $task)
    {
        return view('tasks.edit',compact('task'));
    }

    public function update(Request $request, $id)
    {
        $task = Task::find( $id );

        // if ( auth()->user()->id !== $task->user_id ) {
        //     return response()->json( ['message' => 'Unauthorized'], 401 );
        // }

        if ( $task ) {
            $task->title = $request->input( 'title' );
            $task->description = $request->input( 'description' );
            $task->completed = $request->input( 'completed' );
            $task->save();

            return response()->json( ['message' => 'Task updated successfully', 'task' => $task] );

            // return redirect()->route( 'tasks.index' )
            // ->with( 'success', 'Task updated successfully' );

        } else {
            return response()->json( ['message' => 'Task not found'], 404 );
        }
    }

    public function destroy( $id)
    {
        $task = Task::find( $id );

        // if ( auth()->user()->id !== $task->user_id ) {
        //     return response()->json( ['message' => 'Unauthorized'], 401 );
        // }

        if ( $task ) {
            $task->delete();
            return response()->json( ['message' => 'Task deleted successfully'] );
            // return redirect()->route('tasks.index')->with('success','Task deleted successfully');
        } else {
            return response()->json( ['message' => 'Task not found'], 404 );
        }
    }
}
