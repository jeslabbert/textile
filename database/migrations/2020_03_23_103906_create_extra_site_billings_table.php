<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtraSiteBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_site_billings', function (Blueprint $table) {
            $table->increments('site_extra_id');

            $table->integer('site_id')->nullable();
            $table->integer('module_billing_id')->nullable();

            $table->string('custom_name')->nullable();
            $table->string('custom_description')->nullable();

            $table->integer('total')->nullable();
            $table->float('price')->nullable();

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
        Schema::dropIfExists('extra_site_billings');
    }
}
