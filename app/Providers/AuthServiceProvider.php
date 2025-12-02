<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('super_admin', function ($user) {
            return $user->role === 'super_admin';
        });

        Gate::define('role-casemix', function ($user) {
            return $user->role === 'casemix' || $user->role === 'super_admin';
        });

        Gate::define('role-keuangan', function ($user) {
            return $user->role === 'keuangan' || $user->role === 'super_admin';
        });

    }
}
