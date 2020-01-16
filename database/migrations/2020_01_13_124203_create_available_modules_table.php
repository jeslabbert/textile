<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvailableModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('available_modules', function (Blueprint $table) {
            $table->increments('module_id');
            $table->string('module_name')->nullable();
            $table->integer('type')->default(1);
            //1  Standard Module (Default on system creation) Never deactivated
            //2  Site Module (Front end UI for websites)
            //3  Premium Module (Deactivated on non-subscription)

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
        Schema::dropIfExists('available_modules');
    }
}
