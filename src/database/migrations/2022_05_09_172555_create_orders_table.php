<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('currency_value_id');
            $table->foreign('currency_value_id')->references('id')->on('currency_values')->onDelete('cascade');
            $table->decimal('surcharge_percentage', 4, 2);
            $table->decimal('surcharge_amount', 7, 2);
            $table->decimal('purchased_amount', 7, 2);
            $table->decimal('paid_amount', 7 , 2);
            $table->decimal('discount_percentage', 7, 2);
            $table->decimal('discount_amount', 7 , 2);
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
        Schema::dropIfExists('orders');
    }
}
