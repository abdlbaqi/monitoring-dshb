<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        //
    ];

    public function boot()
    {
        $this->registerPolicies();

        // Gate untuk admin
        Gate::define('admin-only', function ($user) {
            return $user->isAdmin();
        });

        // Gate untuk petugas dan admin
        Gate::define('view-data', function ($user) {
            return $user->isAdmin() || $user->isPetugas();
        });
    }
}