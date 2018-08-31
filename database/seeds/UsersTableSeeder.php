<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    const NAME = 'name';
    const EMAIL = 'email';
    const ACCEPT = 'accept';
    const PASSWORD = 'password';
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

        DB::table('users')->truncate();

        DB::table('users')->insert([
            [
                static::EMAIL =>'user1@gmail.com',
                static::NAME => 'User1',
                static::ACCEPT => 0,
                static::PASSWORD => Hash::make('qwerty123'),
                static::CREATED_AT => '2018-01-01 10:00:00',
                static::UPDATED_AT => '2018-01-01 10:00:00'
            ],
            [
                static::EMAIL =>'user2@gmail.com',
                static::NAME => 'user2',
                static::ACCEPT => 0,
                static::PASSWORD => Hash::make('qwerty123'),
                static::CREATED_AT => '2018-01-01 10:00:00',
                static::UPDATED_AT => '2018-01-01 10:00:00'
            ]
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
