<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommissionSplitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        TODO Check if this is Spark or us that made it
        Schema::create('commission_splits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('role_id')->nullable();
            $table->integer('commission')->default(50);
            $table->boolean('no_sales')->default(false);
            $table->boolean('no_support')->default(false);
            $table->unique(['team_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commission_splits');
    }
}
