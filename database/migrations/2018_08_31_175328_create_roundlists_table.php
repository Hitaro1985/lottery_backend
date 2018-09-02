<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoundlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roundlists', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->integer('rightNumber')->nullable();
            $table->integer('totalbet');
            $table->integer('totalpayout');
            $table->integer('profit');
            $table->boolean('paidstatus')->default(false);
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
        Schema::dropIfExists('roundlists');
    }
}
