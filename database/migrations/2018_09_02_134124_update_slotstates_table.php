<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSlotstatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slotstates', function (Blueprint $table) {
            $table->boolean('1st')->default(true);
            $table->boolean('2nd')->default(true);
            $table->boolean('3rd')->default(true);
            $table->boolean('red')->default(true);
            $table->boolean('black')->default(true);
            $table->boolean('odd')->default(true);
            $table->boolean('even')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
