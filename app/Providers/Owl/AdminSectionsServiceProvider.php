<?php

namespace App\Providers\Owl;

use App\Models\Auth\User;
use App\Models\Auth\Role;
use App\Models\Auth\Permission;
use SleepingOwl\Admin\Admin;
use SleepingOwl\Admin\Providers\AdminSectionsServiceProvider as ServiceProvider;

class AdminSectionsServiceProvider extends ServiceProvider
{

    /**
     * @var array
     */
    protected $sections = [
        User::class => 'App\Http\Admin\Owl\Auth\User',
        Role::class => 'App\Http\Admin\Owl\Auth\Role',
        Permission::class => 'App\Http\Admin\Owl\Auth\Permission',
    ];

    /**
     * Register sections.
     *
     * @param Admin $admin
     * @return void
     */
    public function boot(Admin $admin): void
    {
    	//

        parent::boot($admin);
    }
}
