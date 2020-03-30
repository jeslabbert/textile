<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteSubscriptionTotalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_subscription_totals', function (Blueprint $table) {
            $table->increments('site_subscription_total_id');
            $table->integer('site_id')->nullable();
            $table->string('plan')->nullable();
            $table->integer('user_total')->nullable();
            $table->integer('doc_edited_total')->nullable();

            $table->integer('doc_exported_total')->nullable();
            $table->integer('doc_viewed_total')->nullable();
            $table->integer('doc_total')->nullable();
            $table->integer('wallboard_total')->nullable();
            $table->integer('doc_created_total')->nullable();

            $table->float('add_user_price')->nullable();
            $table->float('add_doc_price')->nullable();

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
        Schema::dropIfExists('site_subscription_totals');
    }
}
