<?php

namespace App\Helper;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtToken
{
    public static function CreateToken($userEmail):string
    {
        // The env('JWT_KEY') fetches the secret key from the Laravel environment variables.
        $key=env('JWT_KEY');
        $payload =[
            'iss'  => 'laravel-token',
            'iat'  => time(),
            'exp'  => time()+60*60,
            'userEmail'  =>$userEmail,
        ];

        $jwt = JWT::encode( $payload, $key, 'HS256' );
        return $jwt;
    }

    public static function CreateTokenForSetPass($userEmail):string
    {
        $key=env('JWT_KEY');
        $payload =[
            'iss'  => 'laravel-pass-token',
            'iat'  => time(),
            'exp'  => time()+60*10,
            'userEmail'  =>$userEmail,
        ];

        $jwt = JWT::encode( $payload, $key, 'HS256' );
        return $jwt;
    }

    public static function VerifyToken($token):string
    {
        try{
            $key = env( 'JWT_KEY' );
            $decoded = JWT::decode( $token, new Key( $key, 'HS256' ) );
            return $decoded->userEmail;
        }
        catch(Exception $e){
            return "Unauthorized";
        }
        
    }

}