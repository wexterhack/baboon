<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('name', 250)->unique();
            $table->string('email', 250)->unique();
            $table->string('password', 60);
            $table->timestamps();
        });
        Schema::create('roles', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });
        Schema::create('permissions', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });
        Schema::create('users_permissions', function (Blueprint $table){
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('permission_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');

            $table->primary(['user_id', 'permission_id']);
        });
        Schema::create('users_roles', function (Blueprint $table){
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('role_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

            $table->primary(['user_id', 'role_id']);
        });
        Schema::create('roles_permissions', function (Blueprint $table){
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('permission_id');

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');

            $table->primary(['role_id','permission_id']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('auth_roles_permissions');
        Schema::dropIfExists('auth_users_roles');
        Schema::dropIfExists('auth_users_permissions');
        Schema::dropIfExists('auth_permissions');
        Schema::dropIfExists('auth_roles');
        Schema::dropIfExists('auth_users');
    }
};
