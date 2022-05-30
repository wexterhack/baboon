<?php
namespace App\Providers\Auth;

use App\Models\Auth\Permission;
use Exception;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }
    /**
     * Bootstrap services.
     *
     * @return bool
     */
    public function boot(): bool
    {
        try {
            Permission::get()->map(function ($permission) {
                Gate::define($permission->slug, function ($user) use ($permission) {
                    return $user->hasPermissionTo($permission);
                });
            });
        } catch (Exception $e) {
            report($e);
            return false;
        }
        return false;
    }
}
