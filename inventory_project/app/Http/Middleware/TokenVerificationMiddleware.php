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
        $token = $request->header( 'token' );
        $result =JwtToken::VerifyToken($token);
        if ( $result == "Unauthorized" ) {
            return response()->json( [
                'status'  => 'Failed',
                'message' => 'Unauthorized',
            ], 401 );
        } else {
            $request->headers->set('email', $result);
            return $next( $request );
        }
        
    }
}
