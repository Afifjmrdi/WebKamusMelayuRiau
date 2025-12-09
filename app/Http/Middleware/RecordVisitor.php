<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Carbon\Carbon;

class RecordVisitor
{
    public function handle(Request $request, Closure $next)
    {
        // Jangan hitung visitor untuk halaman admin
        if ($request->is('admin/*')) {
            return $next($request);
        }

        $ip = $request->ip();
        $today = Carbon::today();

        // Cek apakah sudah tercatat untuk hari ini
        $exists = Visitor::where('ip_address', $ip)
            ->whereDate('visited_at', $today)
            ->exists();

        if (!$exists) {
            Visitor::create([
                'ip_address' => $ip,
                'visited_at' => now(),
            ]);
        }

        return $next($request);
    }
}
