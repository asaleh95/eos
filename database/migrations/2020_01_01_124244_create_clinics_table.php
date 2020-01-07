<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('phone');
            $table->integer('city_id');
            $table->string('address');
            $table->decimal('Longitude', 8, 2);
            $table->decimal('latitude', 8, 2);
            $table->unsignedBigInteger('user_id');
            //foreign key
            $table->foreign('user_id')
            ->references('id')->on('users');
            // $table->foreign('city_id')
            // ->references('id')->on('city');

            $table->softDeletes();
            $table->index(['name', 'city_id','user_id']);
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
        Schema::dropIfExists('clinics');
    }
}
