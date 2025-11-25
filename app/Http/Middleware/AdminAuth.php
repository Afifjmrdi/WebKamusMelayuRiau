<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah session admin_id ada
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login')->with('error', 'Silakan login terlebih dahulu!');
        }

        return $next($request);
    }
}
