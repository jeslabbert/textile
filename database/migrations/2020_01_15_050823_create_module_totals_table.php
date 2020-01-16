<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModuleTotalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_totals', function (Blueprint $table) {
            $table->increments('moduletotal_id');
            $table->string('site_id')->nullable();

            $table->integer('user_total')->nullable();
            $table->integer('doc_edited_total')->nullable();

            $table->integer('doc_exported_total')->nullable();
            $table->integer('doc_viewed_total')->nullable();
            $table->integer('doc_total')->nullable();
            $table->integer('doc_active_total')->nullable();

            $table->integer('billing_month')->nullable();
            $table->integer('billing_year')->nullable();
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
        Schema::dropIfExists('module_totals');
    }
}
