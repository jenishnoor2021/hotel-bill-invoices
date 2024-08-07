<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotel_id')->unsigned()->index();
            $table->text('address')->nullable();
            $table->string('gst_no')->nullable();
            $table->string('gst_name')->nullable();
            $table->string('email')->nullable();
            $table->string('contact')->nullable();
            $table->string('invoice_code')->nullable();
            $table->string('invoice_series')->nullable();
            $table->string('is_active')->default(1)->nullable();
            $table->timestamps();

            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
