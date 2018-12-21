<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommissionCalculationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commission_calculations', function (Blueprint $table) {
            $table->increments('comcalc_id');
            $table->string('invoice_id')->nullable();
            $table->float('invoice_value')->nullable();
            $table->string('billing_period')->nullable();
            $table->integer('team_id')->nullable();
            $table->float('global_percentage')->nullable();
            $table->float('comm_percentage')->nullable();
            $table->float('comm_split')->nullable();
            $table->integer('comm_type')->nullable();
            $table->float('comm_value')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('status')->default(0);
            //0 Unpaid
            //1 Paid
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
        Schema::dropIfExists('commission_calculations');
    }
}
