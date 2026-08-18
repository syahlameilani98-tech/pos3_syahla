<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * 
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek user jika belum login
        if (!$request->user()) {
            return redirect()->route('login')
                ->withErrors(['Silakan login terlebih dahulu']);
        }

        // Mengambil nama role melalui relasi 'role' yang ada di Model User
        // Pastikan tabel roles memiliki kolom 'name' (misal: 'admin', 'kasir', dll)
        $userRole = $request->user()->role ? $request->user()->role->name : null;

        // Jika role user tidak sesuai dengan route yang diminta
        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized');
        }
        
        return $next($request);
    }
}