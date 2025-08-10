<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ApiToken;

class TokenAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $header = $request->header('Authorization', '');

        if (!str_starts_with($header, 'Bearer ')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $token = substr($header, 7);

        $exists = ApiToken::where('token', $token)->exists();

        if (!$exists) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}