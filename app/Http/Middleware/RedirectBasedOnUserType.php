<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class RedirectBasedOnUserType
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            switch (auth()->user()->user_type) {
                case User::TYPE_UTM_STUDENT:
                    return redirect('/dashboard-utm-student');
                case User::TYPE_OTHER_STUDENT:
                    return redirect('/dashboard-other-student');
                case User::TYPE_ADMIN:
                    return redirect('/dashboard-admin');
                case User::TYPE_ADMIN:
                    return redirect('/dashboard-tda');
                case User::TYPE_ADMIN:
                    return redirect('/dashboard-pc');
                case User::TYPE_ADMIN:
                    return redirect('/dashboard-staff');
            }
        }

        return $next($request);
    }
}
