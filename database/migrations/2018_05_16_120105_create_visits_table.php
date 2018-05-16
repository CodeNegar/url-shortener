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
            $table->string('os', 25);
            $table->string('client_type', 25); // e.g browser, feedreader
            $table->string('client_name', 25); // e.g Firefox, Greader
            $table->string('device', 25); // e.g smartphone, desktop
            $table->string('referrer', 100);
            $table->string('ip', 32);
            $table->string('country', 32);
            $table->string('user_agent', 256);
            $table->boolean('is_bot');
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
