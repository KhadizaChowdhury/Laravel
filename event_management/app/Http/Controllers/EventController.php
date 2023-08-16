<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use Exception;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all();
        return response()->json( $events );
    }

    public function show(Event $event)
    {
        return response()->json($event);
    }

    public function eventPage()
    {
        // return view('pages.events.index');
        return view('pages.dashboard.event-page');
    }

    public function ReqById(Request $request)
    {
        $user_id = $request->header( 'u_id' );
        $event_id = $request->input( 'id' );
        // $event =Event::where( 'id', $event_id )->where( 'user_id', $user_id )->find($event_id);
        $event =Event::where( 'id', '=', $event_id )->where( 'user_id', '=', $user_id )->first();

        return $event;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeEvent(Request $request)
    {
        try {
            $validatedData = $request->validate( [
                'title'       => 'required|max:255',
                'description' => 'required',
                'date'        => 'required|date',
                'time'        => 'required',
                'location'    => 'required',
            ] );


            // Fetch user_id from header
            $user_id = $request->header( 'u_id' );
            
            // Merge user_id into validatedData
            $validatedData = array_merge( $validatedData, ['user_id' => $user_id] );

            // Create new event record
            $event = Event::create( $validatedData );

            return response()->json( [
                'status'  => 'success',
                'message' => 'Event recorded successfully',
                'event'  => $event,
            ] );
        } catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'Failed',
                // 'message' => 'Event recorded failed',
                'message' => $e->getMessage(),
            ], status: 200 );
        }
    }

    /**
     * Display the specified resource.
     */
    public function showEvent($id)
    {
        try {
            $event = Event::find($id);

            if ($event) {
                return response()->json($event);
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
    public function updateEvent(Request $request)
    {
        try {
            $event_id = $request->input('id');
            $validatedData = $request->validate([
                'title'       => 'required|max:255',
                'description' => 'required',
                'date'        => 'required|date',
                'time'        => 'required',
                'location'    => 'required',
            ]);

            $user_id = $request->header('u_id');

            $event = Event::where( 'id', $event_id )->where( 'user_id', $user_id )->first();

            if ( !$event ) {
                return response()->json( [
                    'status'  => 'Failed',
                    'message' => 'Event not found',
                ], status: 200 );
            }

            $event->update( $validatedData );

            return response()->json( [
                'status'  => 'success',
                'message' => 'Event updated Successfully',
                'event'    => $event,
            ], status: 200 );
        }
        catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'Failed',
                'message' => $e->getMessage(),
            ] );
        }
    }

    public function deleteEvent(Request $request)
    {
        $user_id = $request->header( 'u_id' );
        $event_id = $request->input( 'id' );

        $event = Event::where( 'id', $event_id )->where( 'user_id', $user_id )->delete();

        // return $event;

        if ($event ) {
            return response()->json( [
                'message' => 'Event deleted successfully'
            ], status: 200 );
        }
        else{
            return response()->json( [
                'message' => 'Event not found',
            ], status: 200 );
        }
    }
}
