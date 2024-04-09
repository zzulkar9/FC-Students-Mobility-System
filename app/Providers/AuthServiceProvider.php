<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // Register your model policies here, for example:
        // 'App\Models\User' => 'App\Policies\UserPolicy',
    ];

    public function boot()
    {
        dd('AuthServiceProvider is loaded');
        $this->registerPolicies();

        Gate::define('manage-course-handbook', function ($user) {
            // Temporary debug output
            dd('Gate accessed', $user->isAdmin(), $user->isProgramCoordinator());
        
            return $user->isAdmin() || $user->isProgramCoordinator();
        });

        // Gate::define('manage-course-handbook', function ($user) {
        //     return $user->isAdmin() || $user->isProgramCoordinator();
        // });
    }
}
