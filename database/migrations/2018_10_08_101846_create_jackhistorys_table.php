<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJackhistorysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jackhistories', function (Blueprint $table) {
            $table->increments('id');
            $table->float('credit')->default(0);
            $table->string('agent')->nullable();
            $table->boolean('notify')->default(false);
            $table->dateTime('assign_time')->default(now());
            $table->string('jacks');
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
        Schema::dropIfExists('jackhistorys');
    }
}
