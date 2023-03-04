<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Coderjp\Forecast\WeatherCodes;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('days', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('forecast_id')->unsigned();
            $table->date('date');
            $table->enum('code', array_column(WeatherCodes::cases(), 'name'));
            $table->smallInteger('temperature');
            $table->timestamps();
            $table->foreign('forecast_id')->references('id')->on('forecasts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('days');
    }
};
