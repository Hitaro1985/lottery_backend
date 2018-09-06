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
        //
        Schema::table('slotstates', function (Blueprint $table) {
            for ($i = 0; $i < 37; $i ++) {
                $table->string('s'.$i)->default("1|0")->change();
            }
            $table->string('1st')->default("1|0")->change();
            $table->string('2nd')->default("1|0")->change();
            $table->string('3rd')->default("1|0")->change();
            $table->string('red')->default("1|0")->change();
            $table->string('black')->default("1|0")->change();
            $table->string('odd')->default("1|0")->change();
            $table->string('even')->default("1|0")->change();
            $table->string('f118')->default("1|0");
            $table->string('f1936')->default("1|0");
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
