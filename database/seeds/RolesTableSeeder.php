<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    const ROLE = 'role';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('roles')->truncate();

        DB::table('roles')->insert([
            [
                static::ROLE =>'Admin'
            ],
            [
                static::ROLE =>'Master Agent'
            ],
            [
                static::ROLE =>'Agent'
            ]
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
