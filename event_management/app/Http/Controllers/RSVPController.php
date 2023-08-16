<?php

namespace App\Http\Controllers;
use App\Models\Event;
use App\Models\RSVP;
use Illuminate\Http\Request;

class RSVPController extends Controller
{
    public function create(Request $request, Event $event)
    {
        $user_id = $request->header( 'u_id' );
        $rsvp = RSVP::where( 'user_id', $user_id )
            ->where( 'event_id', $event->id )
            ->first();

        if ( $rsvp ) {
            return response()->json( $rsvp, 200 );
        }

        return response()->json( ['message' => 'No RSVP found for this user and event.'], 200 );

    }

    public function store(Request $request, Event $event)
    {
        $request->validate( [
            'status' => 'required|in:attending,maybe,not_attending',
        ] );

        $user_id = $request->header( 'u_id' );

        $rsvp = RSVP::firstOrNew( [
            'user_id'  => $user_id,
            'event_id' => $event->id,
        ] );

        $rsvp->status = $request->status;
        $rsvp->save();

        return response()->json( $rsvp, 200 );          
    }
}
