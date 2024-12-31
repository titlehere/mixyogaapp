<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\StudioYoga;

class InjectStudioData
{
    public function handle(Request $request, Closure $next)
    {
        $user = session('user');
        $studio = null;

        if ($user) {
            $studio = StudioYoga::where('owner_uuid', $user->owner_uuid)->first();
        }

        // Periksa jika studio tidak ditemukan
        // if (!$studio) {
        //     logger()->error('Studio not found for user: ' . $user->owner_uuid);
        //     return redirect()->route('owner.dashboard')->with('error', 'Studio tidak ditemukan.');
        // }        

        // Bagikan $studio ke semua view dan simpan di session
        session(['studio' => $studio]);
        view()->share('studio', $studio);

        return $next($request);
    }
}