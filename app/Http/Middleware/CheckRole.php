<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $roles = explode(',', $role);
        
        if (!$request->user() || !in_array($request->user()->role, $roles)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Accès non autorisé.'], 403);
            }
            return redirect()->route('dashboard')->with('error', 'Vous n\'avez pas la permission d\'accéder à cette page.');
        }

        return $next($request);
    }
}
