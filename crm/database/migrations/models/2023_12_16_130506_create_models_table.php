<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('models', function (Blueprint $table) {
            $table->id('car_model_id');
            $table->string('car_name');
            $table->unsignedBigInteger('car_brand_id');
            $table->unsignedBigInteger('car_type_id');

            $table->foreign('car_brand_id')->references('car_brand_id')->on('brands')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('car_type_id')->references('car_type_id')->on('types')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('models');
    }
};
