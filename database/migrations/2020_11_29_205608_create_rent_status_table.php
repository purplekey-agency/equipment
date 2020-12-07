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
            $table->boolean('rented');
            $table->integer('user_rented_id');
            $table->date('rented_at');
            $table->date('returned_at');
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
