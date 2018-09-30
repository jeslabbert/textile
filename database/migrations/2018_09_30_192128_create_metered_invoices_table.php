<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeteredInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metered_invoices', function (Blueprint $table) {
            $table->increments('meteredinvoice_id');
            $table->integer('user_id')->nullable()->index();
            $table->integer('team_id')->nullable()->index();
            $table->string('provider_id');
            $table->text('description')->nullable();
            $table->decimal('total')->nullable();
            $table->decimal('tax')->nullable();
            $table->string('card_country')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_zip')->nullable();
            $table->string('billing_country')->nullable();
            $table->string('vat_id', 50)->nullable();
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
        Schema::dropIfExists('metered_invoices');
    }
}
