<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('team_name')->unique();
            $table->string('team_logo')->nullable();
            $table->string('team_logo_name')->nullable();
            $table->integer('series_id')->nullable();
            $table->softDeletes(); // Adds deleted_at column
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
        Schema::dropIfExists('teams');
    }
}
