<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id')->nullable();
            $table->string('b_date')->nullable();
            $table->text('address')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('barcode')->nullable();
            $table->string('pnr_no')->nullable();
            $table->string('passenger_name')->nullable();
            $table->string('seat')->nullable();
            $table->string('meal')->nullable();
            $table->string('passenger_pnr')->nullable();
            $table->string('flogo')->nullable();
            $table->string('journey')->nullable();
            $table->string('air_lines')->nullable();
            $table->string('journy_date')->nullable();
            $table->string('duration')->nullable();
            $table->string('flight_number')->nullable();
            $table->string('departure')->nullable();
            $table->string('short_from')->nullable();
            $table->string('departure_time')->nullable();
            $table->string('d_date')->nullable();
            $table->string('airport_name')->nullable();
            $table->string('terminal')->nullable();
            $table->string('arrival')->nullable();
            $table->string('short_to')->nullable();
            $table->string('arrival_time')->nullable();
            $table->string('a_date')->nullable();
            $table->string('airport_name_to')->nullable();
            $table->string('to_terminal')->nullable();
            $table->string('generation')->nullable();
            $table->string('check_in_weight')->nullable();
            $table->string('cabin_weight')->nullable();
            $table->string('file')->nullable();
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
        Schema::dropIfExists('flights');
    }
}
