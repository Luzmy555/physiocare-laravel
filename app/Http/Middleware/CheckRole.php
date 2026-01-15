<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     * Usage in routes: ->middleware('role:Administrador') or ->middleware('role:Paciente,Admin')
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (! $user) {
            // not authenticated
            return redirect()->route('login');
        }

        // If Usuario model has 'rol' relation returning Rol model
        $userRole = null;
        if (method_exists($user, 'rol')) {
            try {
                $r = $user->rol;
                $userRole = $r ? ($r->nombre_rol ?? $r->name ?? null) : null;
            } catch (\Throwable $e) {
                $userRole = null;
            }
        }

        // if roles not provided, allow
        if (empty($roles)) {
            return $next($request);
        }

        foreach ($roles as $role) {
            if (strcasecmp(trim($role), trim($userRole)) === 0) {
                return $next($request);
            }
        }

        // not authorized
        abort(403, 'No autorizado');
    }
}
