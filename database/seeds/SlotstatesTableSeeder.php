<?php

use Illuminate\Database\Seeder;

class SlotstatesTableSeeder extends Seeder
{
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('slotstates')->truncate();

        DB::table('slotstates')->insert([
            [
                static::CREATED_AT => '2018-01-01 10:00:00',
                static::UPDATED_AT => '2018-01-01 10:00:00'
            ]
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
