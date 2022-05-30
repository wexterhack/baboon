<?php

namespace Database\Seeders\Auth;

use App\Models\Auth\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $administrator = new Role();
        $administrator->name = 'Administrator';
        $administrator->slug = 'administrator';
        $administrator->save();

        $moderator = new Role();
        $moderator->name = 'Moderator';
        $moderator->slug = 'moderator';
        $moderator->save();

        $publisher = new Role();
        $publisher->name = 'Publisher';
        $publisher->slug = 'publisher';
        $publisher->save();
    }
}
