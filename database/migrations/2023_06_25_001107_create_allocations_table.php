<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allocations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bus_id');
            $table->unsignedBigInteger('travel_id');
            $table->unsignedBigInteger('staff_id');
            $table->integer('seat_cost');
            $table->date('travel_date');
            $table->string('status');
            $table->timestamps();
            $table->foreign('bus_id')->references('id')->on('buses')->onDelete('cascade');
            $table->foreign('travel_id')->references('id')->on('travel')->onDelete('cascade');
            $table->foreign('staff_id')->references('id')->on('staff')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('allocations');
    }
}
