<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('match_schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('series_id');
            $table->integer('team_id_one');
            $table->integer('team_id_two');
            $table->integer('match_no');
            $table->dateTime('schedule_date');
            $table->enum('status', [0, 1]);
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
        Schema::dropIfExists('match_schedules');
    }
}
