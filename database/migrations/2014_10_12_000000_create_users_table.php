<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname')->nullable();
            $table->string('lastname');
            $table->string('email')->unique();
            $table->integer('phone')->unique()->nullable();
            $table->text('address')->nullable();
            $table->string('image')->nullable()->default("img/undraw_profile.svg");
            $table->string('identity')->nullable();
            $table->float('balance')->default(0);
            $table->string('income')->nullable();
            $table->boolean('is_admin')->default(0);
            $table->boolean('active')->default(0);
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
