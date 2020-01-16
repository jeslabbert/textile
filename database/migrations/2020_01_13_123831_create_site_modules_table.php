<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_modules', function (Blueprint $table) {
            $table->increments('site_module_id');
            $table->integer('team_id')->nullable();
            $table->integer('site_id')->nullable();
            $table->integer('module_id')->nullable();
            $table->boolean('hard_lock')->nullable();
            $table->boolean('soft_lock')->nullable();
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
        Schema::dropIfExists('site_modules');
    }
}
