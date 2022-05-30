<?php

namespace App\Traits\Auth;

use App\Models\Auth\Role;
use App\Models\Auth\Permission;

trait HasRolesAndPermissions
{
    /**
     * @return mixed
     */
    public function roles(): mixed
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    /**
     * @return mixed
     */
    public function permissions(): mixed
    {
        return $this->belongsToMany(Permission::class, 'users_permissions');
    }

    public function hasRole(...$roles): bool
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('slug', $role)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $permission
     * @return bool
     */
    public function hasPermission($permission): bool
    {
        return (bool)$this->permissions->where('slug', $permission)->count();
    }

    /**
     * @param $permission
     * @return bool
     */
    public function hasPermissionTo($permission): bool
    {
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission->slug);
    }

    /**
     * @param $permission
     * @return bool
     */
    public function hasPermissionThroughRole($permission): bool
    {
        foreach ($permission->roles as $role) {
            if ($this->roles->contains($role)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param array $permissions
     * @return mixed
     */
    public function getAllPermissions(array $permissions): mixed
    {
        return Permission::whereIn('slug', $permissions)->get();
    }

    /**
     * @param mixed ...$permissions
     * @return $this
     */
    public function givePermissionsTo(...$permissions): static
    {
        $permissions = $this->getAllPermissions($permissions);
        if ($permissions === null) {
            return $this;
        }
        $this->permissions()->saveMany($permissions);
        return $this;
    }

    /**
     * @param mixed ...$permissions
     * @return $this
     */
    public function deletePermissions(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        $this->permissions()->detach($permissions);
        return $this;
    }

    /**
     * @param mixed ...$permissions
     * @return HasRolesAndPermissions
     */
    public function refreshPermissions(...$permissions)
    {
        $this->permissions()->detach();
        return $this->givePermissionsTo($permissions);
    }
}
