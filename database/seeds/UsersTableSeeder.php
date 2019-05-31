<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
		'name' => str_random(10),
		'email' => str_random(10).'@qq.com',
		'password' => bcrypt('secret'),
		'remember_token' => bcrypt('secret'),
		'created' => time()
	]);
    }
}
