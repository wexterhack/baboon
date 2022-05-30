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
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('author_id');
            $table->foreign('author_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->string('title', 250)->unique();
            $table->string('slug', 250)->unique();
            $table->text('content');
            $table->boolean('published');
            $table->timestamps();
        });
        Schema::create('comments', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->unsignedBigInteger('on_post');
            $table->unsignedBigInteger('from_user');
            $table->foreign('on_post')
                ->references('id')->on('posts')
                ->onDelete('cascade');
            $table->foreign('from_user')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->text('body');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
        Schema::dropIfExists('posts');
    }
};
