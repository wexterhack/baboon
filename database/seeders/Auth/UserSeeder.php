<?php

namespace Database\Seeders\Auth;

use App\Models\Auth\Role;
use App\Models\Auth\User;
use App\Models\Auth\Permission;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $administrator = Role::where('slug', 'administrator')->first();
        $moderator = Role::where('slug', 'moderator')->first();
        $publisher = Role::where('slug', 'publisher')->first();

        $admin_user = new User();
        $admin_user->name = 'Monkey King';
        $admin_user->email = 'monkeyking@banana.com';
        $admin_user->password = bcrypt('i_love_banana');
        $admin_user->save();
        $admin_user->roles()->attach($administrator);

        $pub_user = new User();
        $pub_user->name = 'Red Ass';
        $pub_user->email = 'redass@banana.com';
        $pub_user->password = bcrypt('i_love_my_ass');
        $pub_user->save();
        $pub_user->roles()->attach($publisher);
    }
}
