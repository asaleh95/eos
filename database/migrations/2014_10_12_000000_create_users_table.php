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
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('country_id');
            $table->integer('city_id');
            $table->string('phone');
            $table->string('aboutme')->nullable();
            $table->string('website')->nullable();
            $table->string('title');
            $table->string('role_id')->default(0);
            $table->text('image')->nullable();
            //foreign key
            // $table->foreign('country_id')
            // ->references('id')->on('country');
            // $table->foreign('city_id')
            // ->references('id')->on('city');

            $table->softDeletes();
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
