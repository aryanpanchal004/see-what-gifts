<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_data', function (Blueprint $table) {
            $table->id();

            // shipping id
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders');

            // personal details
            $table->string("full_name");
            $table->string("phone_number");


            // shipping details
            $table->string("address_line_1");
            $table->string("address_line_2");
            $table->string("city");
            $table->string("state");
            $table->string("zipcode");

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
        //
    }
};
