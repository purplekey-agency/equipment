<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_status', function (Blueprint $table) {
            $table->id();
            $table->integer('equipment_id');
            $table->boolean('rented')->default(false);
            $table->integer('user_rented_id')->nullable();
            $table->date('rented_at')->nullable();
            $table->date('returned_at')->nullable();
            $table->integer('user_auth')->nullable();
            $table->integer('number_of_times_rented')->default(0);
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
        Schema::dropIfExists('rent_status');
    }
}
