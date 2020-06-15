<?php

namespace App\Providers;

use App\Policies\ProjectPolicy;
use App\Project;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        Project::class => ProjectPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /**
         * Determine whether the user is an admin.
         *
         * @param User $user
         * @return bool
         */
        Gate::define('isAdmin',function ($user) {
            return $user->isAdmin;
        });
    }
}
