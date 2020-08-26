<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRuncloudServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('runcloud_servers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type')->nullable();
            //1 Self
            //2 Cloud
            $table->integer('user_id')->nullable();
            $table->string('name')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('server_id')->nullable();
            $table->string('server_user')->nullable();
            $table->string('server_password')->nullable();
            $table->string('api_key')->nullable();
            $table->string('api_secret')->nullable();
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
        Schema::dropIfExists('runcloud_servers');
    }
}
