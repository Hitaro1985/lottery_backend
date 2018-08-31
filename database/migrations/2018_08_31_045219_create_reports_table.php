<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            $table->text('roundname');
            $table->integer('roundnumber');
            $table->text('rightNumber');
            $table->text('first');
            $table->text('second');
            $table->text('third');
            $table->text('firsttoeighteen');
            $table->text('eighteentothirtysix');
            $table->text('blackcolor');
            $table->text('redcolor');
            $table->text('odd');
            $table->text('even');
            $table->text('totalmoney');
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
        Schema::dropIfExists('reports');
    }
}
