<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id('car_id');
            $table->unsignedBigInteger('car_model_id');
            $table->integer('car_year');
            $table->unsignedBigInteger('car_color_id');
            $table->string('car_vin');
            $table->integer('price');
            $table->string('status');
            $table->timestamps();
            // внешние ключи для связей
            $table->foreign('car_model_id')->references('car_model_id')->on('models')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('car_color_id')->references('car_color_id')->on('colors')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cars');
    }
};
