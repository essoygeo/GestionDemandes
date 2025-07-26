<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Intercepte la requête et vérifie le rôle de l'utilisateur.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();


        // Si non connecté ou rôle non autorisé
        if (!Auth::check() || !in_array($user->role, $roles)) {

            return redirect()->route('login')->with('error', 'Accès refusé');
        }
        return $next($request);
    }
}
