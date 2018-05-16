<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('url_id')->unsigned()->index('url_id');;
            $table->string('os', 25)->nullable();;
            $table->string('client_type', 25)->nullable();; // e.g browser, feedreader
            $table->string('client_name', 25)->nullable();; // e.g Firefox, Greader
            $table->string('device', 25)->nullable();; // e.g smartphone, desktop
            $table->string('referrer', 100)->nullable();;
            $table->string('ip', 32);
            $table->string('country', 32)->nullable();;
            $table->string('user_agent', 256)->nullable();;
            $table->boolean('is_bot')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visits');
    }
}
