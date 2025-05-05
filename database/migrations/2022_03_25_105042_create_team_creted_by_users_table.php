<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamCretedByUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_creted_by_users', function (Blueprint $table) {
            $table->id();
            $table->string('user_ip');
            $table->string('series_id');
            $table->text('cap_vc_details');
            $table->text('players_details');
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
        Schema::dropIfExists('team_creted_by_users');
    }
}
