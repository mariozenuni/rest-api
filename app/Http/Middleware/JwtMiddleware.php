<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class JwtMiddleware
{
      public function handle($request, Closure $next)
    {
        try {
      
            $user = JWTAuth::parseToken()->authenticate();

            $request->merge(['auth_user' => $user]);
        } 
        catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token has expired'], 401);
        } 
        catch (TokenInvalidException $e) {
            return response()->json(['error' => 'Token is invalid'], 401);
        } 
        catch (JWTException $e) {
            return response()->json(['error' => 'Token is missing or invalid'], 401);
        } 
        catch (Exception $e) {
            return response()->json(['error' => 'Authorization error'], 401);
        }

        return $next($request);
    }
}
