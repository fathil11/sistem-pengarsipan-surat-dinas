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
            $table->bigIncrements('id');
            $table->string('nip')->unique()->nullable();
            $table->string('name');
            $table->unsignedBigInteger('user_position_id');
            $table->foreign('user_position_id')->references('id')->on('user_positions');
            $table->unsignedBigInteger('user_position_detail_id')->nullable();
            $table->foreign('user_position_detail_id')->references('id')->on('user_position_details');
            $table->unsignedBigInteger('user_department_id')->nullable();
            $table->foreign('user_department_id')->references('id')->on('user_departments');
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
            $table->string('username')->unique()->nullable();
            $table->string('password');
            $table->softDeletes();
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
