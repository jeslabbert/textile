<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_commissions', function (Blueprint $table) {
            $table->increments('commission_id');
            $table->integer('team_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('first_user_id')->nullable();
            $table->string('first_split')->nullable();
            $table->string('second_name')->nullable();
            $table->string('second_user_id')->nullable();
            $table->string('second_split')->nullable();
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
        Schema::dropIfExists('team_commissions');
    }
}
