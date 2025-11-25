<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Carbon\Carbon;

class TrackVisitor
{
    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();
        $today = Carbon::today();

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
