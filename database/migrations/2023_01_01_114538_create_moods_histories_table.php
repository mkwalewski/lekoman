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
        Schema::create('moods_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('moods_id');
            $table->dateTime('history_time');
            $table->foreign('moods_id')->references('id')->on('moods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('moods_histories');
    }
};
