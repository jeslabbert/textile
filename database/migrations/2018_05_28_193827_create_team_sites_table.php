<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_sites', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team_id')->nullable();
            $table->string('fqdn');
            $table->integer('website_id');
            $table->string('creator');
            $table->string('creator_email');
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
        Schema::dropIfExists('team_sites');
    }
}
