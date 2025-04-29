<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotel_id')->unsigned()->index();
            $table->string('invoice_no')->nullable();
            $table->string('file')->nullable();
            $table->string('invoice_date')->nullable();
            $table->string('guest_name1')->nullable();
            $table->string('guest_name2')->nullable();
            $table->string('guest_email')->nullable();
            $table->string('guest_mobile')->nullable();
            $table->string('guest_gst_no')->nullable();
            $table->string('guest_gst_name')->nullable();
            $table->string('check_in')->nullable();
            $table->string('check_out')->nullable();
            $table->string('invoice_total')->nullable();
            $table->string('discount_value')->default(0);
            $table->string('discount_type')->default('fix');
            $table->string('final_amount')->default(0);
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
        Schema::dropIfExists('invoices');
    }
}
