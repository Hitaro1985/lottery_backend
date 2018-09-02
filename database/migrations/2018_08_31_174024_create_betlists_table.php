<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBetlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('betlists', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->text('betNumber');
            $table->integer('total');
            $table->text('round');
            $table->text('wls')->nullable();
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
        Schema::dropIfExists('betlists');
    }
}
