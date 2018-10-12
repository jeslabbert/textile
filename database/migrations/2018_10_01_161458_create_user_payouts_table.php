<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_payouts', function (Blueprint $table) {
            $table->increments('payout_id');
            $table->integer('payoutprovider_id')->nullable();
            //1 Paypal
            $table->integer('user_id')->nullable();
            $table->string('provider_user_details')->nullable();
            //Paypal address etc
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
        Schema::dropIfExists('user_payouts');
    }
}
