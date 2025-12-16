<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Check if user has the correct role
        if (auth()->user()->role !== $role) {
            // Redirect to appropriate dashboard instead of 403
            $userRole = auth()->user()->role;
            if ($userRole === 'teacher') {
                return redirect()->route('teacher.dashboard')->with('error', 'Akses ditolak');
            } elseif ($userRole === 'student') {
                return redirect()->route('student.dashboard')->with('error', 'Akses ditolak');
            }
            
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
