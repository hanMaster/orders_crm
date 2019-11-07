<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_id');
            $table->text('order_item');
            $table->integer('executor_id')->nullable();
            $table->integer('idx')->nullable();
            $table->integer('ed_id');
            $table->double('quantity');
            $table->text('comment')->nullable();
            $table->string('delivery_date')->nullable();
            $table->string('attached_file')->nullable();
            $table->boolean('done')->default(false);
            $table->boolean('confirmed')->default(false);
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
        Schema::dropIfExists('order_details');
    }
}
