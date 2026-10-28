<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
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
        // Admin-only capabilities
        Gate::define('manage-users', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('manage-master-data', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('cancel-transaction', function (User $user) {
            return $user->isAdmin();
        });

        // Staff and Admin capabilities
        Gate::define('manage-sales', function (User $user) {
            return in_array($user->role, ['admin', 'staff']);
        });

        Gate::define('manage-purchases', function (User $user) {
            return in_array($user->role, ['admin', 'staff']);
        });
    }
}
