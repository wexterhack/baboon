<?php

namespace App\Models\Auth;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\Auth\HasRolesAndPermissions;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable implements AuthenticatableContract, CanResetPasswordContract
{
    use HasFactory, HasRolesAndPermissions;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    // user has many posts
    public function posts(): HasMany
    {
        return $this->hasMany('App\Posts', 'author_id');
    }

    // user has many comments
    public function comments(): HasMany
    {
        return $this->hasMany('App\Comments', 'from_user');
    }

    public function can_post()
    {
        $role = $this->role;
        if ($role == 'author' || $role == 'admin') {
            return true;
        }
        return false;
    }

    public function is_admin()
    {
        $role = $this->role;
        if ($role == 'admin') {
            return true;
        }
        return false;
    }
}
