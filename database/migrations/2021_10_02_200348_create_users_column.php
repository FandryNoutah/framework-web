<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->date('birth')->nullable();
            $table->enum('marital_status', ['Single', 'Married', 'Other'])->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->float('postal_code', 3, 0)->nullable();
            $table->string('occupation')->nullable();
            $table->string('occupation_place')->nullable();
            $table->string('occupation_duration')->nullable();
            $table->float('monthly_income')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_column');
    }
}
