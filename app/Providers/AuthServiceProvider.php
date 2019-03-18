<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerAdministratorPolicies();
        $this->registerEditorPolicies();
        $this->registerOperatorPolicies();

        //
    }
    public function registerAdministratorPolicies()
    {
        Gate::define('role-permission', function ($user) {
            return $user->hasAccess(['role-permission']);
        });
        Gate::define('create-data', function ($user) {
            return $user->hasAccess(['create-data']);
        });
        Gate::define('module', function ($user) {
            return $user->hasAccess(['module']);
        });

        Gate::define('update-data', function ($user,$post) {
            return $user->hasAccess(['update-data']) or $user->id == $post->user_id;
        });
        Gate::define('show-data', function ($user) {
            return $user->hasAccess(['show-data']);
        });
        Gate::define('delete-data', function ($user) {
            return $user->hasAccess(['delete-data']);
        });
        Gate::define('see-all-drafts', function ($user) {
            return $user->inRole('owner');
        });
    }
    public function registerEditorPolicies()
    {
        Gate::define('role-permission', function ($user) {
            return $user->hasAccess(['role-permission']);
        });
        Gate::define('create-data', function ($user) {
            return $user->hasAccess(['create-data']);
        });
        Gate::define('update-data', function ($user) {
            return $user->hasAccess(['update-data']);
        });
        Gate::define('show-data', function ($user) {
            return $user->hasAccess(['show-data']);
        });
        Gate::define('delete-data', function ($user) {
            return $user->hasAccess(['delete-data']);
        });
        Gate::define('module', function ($user) {
            return $user->hasAccess(['module']);
        });
    }
    public function registerOperatorPolicies()
    {
        Gate::define('role-permission', function ($user) {
            return $user->hasAccess(['role-permission']);
        });
        Gate::define('create-data', function ($user) {
            return $user->hasAccess(['create-data']);
        });
        Gate::define('show-data', function ($user) {
            return $user->hasAccess(['show-data']);
        });
        Gate::define('update-data', function ($user) {
            return $user->hasAccess(['update-data']);
        });
        Gate::define('delete-data', function ($user) {
            return $user->hasAccess(['delete-data']);
        });
        Gate::define('module', function ($user) {
            return $user->hasAccess(['module']);
        });
    }
}
