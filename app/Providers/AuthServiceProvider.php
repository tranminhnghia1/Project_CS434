<?php

namespace App\Providers;
use App\Models\Permission;
use App\Models\User;
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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::define('product.list', function ($user) {
        //     return $user->hasPermission('product.list');
        // });

        $permissions = Permission::all();

        foreach($permissions as $permission){
            Gate::define($permission->slug, function (User $user) use($permission) {
                return $user->hasPermission($permission->slug);
            });
        }
        //
    }
}
