<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mettings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->dateTime('date');
            $table->integer('country_id');
            $table->integer('city_id');
            $table->string('qrcode')->nullable();
            // $table->integer('user_id');
            $table->text('description')->nullable();
            $table->enum('type', ['eos', 'international']);
            $table->softDeletes();
            $table->index(['name', 'city_id','type']);
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
        Schema::dropIfExists('mettings');
    }
}
