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
        Schema::create('medicines_doses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medicines_id');
            $table->float('amount');
            $table->string('schedule')->default('everyday');
            $table->boolean('active')->default(true);
            $table->foreign('medicines_id')->references('id')->on('medicines');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medicines_doses');
    }
};
