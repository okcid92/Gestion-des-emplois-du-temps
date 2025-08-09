<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        Gate::define('administrator', function ($user) {
            return $user->role === 'administrator';
        });

        Gate::define('professor', function ($user) {
            return $user->role === 'professor';
        });

        Gate::define('student', function ($user) {
            return $user->role === 'student';
        });
    }
}
