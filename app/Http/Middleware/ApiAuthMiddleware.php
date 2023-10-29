<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Token;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization');

        if (strpos($token, 'Bearer ') === 0) {
            $token = str_replace('Bearer ', '', $token);
        }

        $user = $this->getUserFromToken($token);
        if (!$user) abort(403);

        $request->merge(['user' => $user]);
        return $next($request);

    }

    private function getUserFromToken($token)
    {
        $token = Token::where('token', $token)->first();
        if(!$token) return null;
        return $token->user;
    }
}
