<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user_id = $request->header( 'u_id' );

        // Fetch the user with that ID
        $user = User::find( $user_id );

        if ( $user && $user->role != 1 ) {
            // Redirect to a different page, perhaps the homepage or a custom error page
            return redirect( '/' );
        } else {
            // dashboard
            return $next( $request );
        }
    }
}
