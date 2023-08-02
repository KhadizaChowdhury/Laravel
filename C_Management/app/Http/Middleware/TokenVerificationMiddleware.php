<?php

namespace App\Http\Middleware;

use App\Helper\JwtToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $token = $request->header( 'token' );
        $token = $request->cookie( 'token' );
        $result =JwtToken::VerifyToken($token);
        if ( $result == "Unauthorized" ) {
            return redirect( '/user-login' );
        } else {
            $request->headers->set('email', $result->userEmail);
            $request->headers->set('id', $result->userId);
            return $next( $request );
        }
        
    }
}
