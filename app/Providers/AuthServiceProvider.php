<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Role;
use App\Models\User;
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
        $this->defineGateCategory();
        $this->defineGateMenu();
        $this->defineGateProduct();
        $this->defineGateRole();
        $this->defineGateUser();
    }

    protected function defineGateCategory()
    {
        Gate::define('add_category','App\Policies\CategoryPolicy@create');
        Gate::define('edit_category','App\Policies\CategoryPolicy@update');
        Gate::define('delete_category','App\Policies\CategoryPolicy@delete');
    }
    protected function defineGateMenu()
    {
        Gate::define('add_menu','App\Policies\MenuPolicy@create');
        Gate::define('edit_menu','App\Policies\MenuPolicy@update');
        Gate::define('delete_menu','App\Policies\MenuPolicy@delete');
    }
    protected function defineGateProduct()
    {
        Gate::define('add_product','App\Policies\ProductPolicy@create');
        Gate::define('edit_product','App\Policies\ProductPolicy@update');
        Gate::define('delete_product','App\Policies\ProductPolicy@delete');
    }
    protected function defineGateRole()
    {
        Gate::define('list_role','App\Policies\RolePolicy@create');
        Gate::define('add_role','App\Policies\RolePolicy@create');
        Gate::define('edit_role','App\Policies\RolePolicy@update');
        Gate::define('delete_role','App\Policies\RolePolicy@delete');
    }
    protected function defineGateUser()
    {
        Gate::define('list_user','App\Policies\UserPolicy@create');
        Gate::define('add_user','App\Policies\UserPolicy@create');
        Gate::define('edit_user','App\Policies\UserPolicy@update');
        Gate::define('delete_user','App\Policies\UserPolicy@delete');
    }
}
