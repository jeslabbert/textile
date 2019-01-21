<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteTotalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_totals', function (Blueprint $table) {
            $table->increments('sitetotal_id');
            $table->string('site_id')->nullable();
            $table->integer('portfolio_total')->nullable();
            $table->integer('company_total')->nullable();
            $table->integer('bu_id')->nullable();
            $table->string('bu_name')->nullable();
            $table->integer('department_total')->nullable();
            $table->integer('employeelevel_total')->nullable();

            $table->integer('task_total')->nullable();
            $table->integer('task_active')->nullable();

            $table->integer('billing_month')->nullable();
            $table->integer('billing_year')->nullable();

            $table->integer('task_transactions_total')->nullable();
            $table->integer('mobile_user_total')->nullable();
            $table->integer('cloud_user_total')->nullable();
            $table->integer('both_user_total')->nullable();
            $table->integer('request_user_total')->nullable();

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
        Schema::dropIfExists('site_totals');
    }
}
