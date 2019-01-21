<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGlobalCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('global_commissions', function (Blueprint $table) {
            $table->increments('globalcomm_id');
            $table->integer('team_id')->nullable();
            $table->float('comm1')->nullable();
            $table->float('comm2')->nullable();
            $table->float('comm3')->nullable();
            $table->float('global_commission')->default(95);

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
        Schema::dropIfExists('global_commissions');
    }
}
