<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(){
        Schema::create('sales', function (Blueprint $table) {
            $table->id('sale_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('car_id');
            $table->string('email')->nullable();
            $table->integer('price');
            $table->boolean('help')->default(false);
            $table->boolean('truck')->default(false);
            $table->string('country')->nullable();
            $table->text('address')->nullable();
            $table->integer('paymentMethod');
            $table->string('sale_status');
            $table->unsignedBigInteger('employee_id');
            // внешние ключи для связей
            $table->foreign('client_id')->references('client_id')->on('clients')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('car_id')->references('car_id')->on('cars')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('employee_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales');
    }
};
