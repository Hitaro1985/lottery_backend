<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    const NAME = 'name';
    const EMAIL = 'email';
    const ROLE_ID = 'role_id';
    const PASSWORD = 'password';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const PHONENO = 'phoneno';
    const AMOUNT = 'amount';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('admins')->truncate();

        DB::table('admins')->insert([
            [
                static::EMAIL =>'tony123@gmail.com',
                static::NAME => 'Tony',
                static::ROLE_ID => 1,
                static::PASSWORD => Hash::make('asdfasdf'),
                static::CREATED_AT => '2018-01-01 10:00:00',
                static::UPDATED_AT => '2018-01-01 10:00:00',
                static::PHONENO => '+6012344567',
                static::AMOUNT => 1000
            ],
            [
                static::EMAIL =>'masteragent@gmail.com',
                static::NAME => 'masteragent',
                static::ROLE_ID => 2,
                static::PASSWORD => Hash::make('asdfasdf'),
                static::CREATED_AT => '2018-01-01 10:00:00',
                static::UPDATED_AT => '2018-01-01 10:00:00',
                static::PHONENO => '+6012344567',
                static::AMOUNT => 0
            ],
            [
                static::EMAIL =>'agent@gmail.com',
                static::NAME => 'agent',
                static::ROLE_ID => 3,
                static::PASSWORD => Hash::make('asdfasdf'),
                static::CREATED_AT => '2018-01-01 10:00:00',
                static::UPDATED_AT => '2018-01-01 10:00:00',
                static::PHONENO => '+6012344567',
                static::AMOUNT => 0
            ]
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
