<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{

		DB::table('users')->delete();

		$userData = array(
			array(
				'id' => 1,
				'name' => 'admin_insight',
				'email' => 'devd4d@yopmail.com',
				'first_name' => 'Admin',
				'last_name' => 'Insight',
				'email_verified_at' =>  '2019-01-29 17:54:21',
				'password' => bcrypt('qwert@123'),
				'remember_token' => null,
				'website_url' => null,
				'is_active' => '1',
				'lower_price'   => '1',
				'medium_price'  => '3',
				'higher_price'  =>'5',
				'created_at' =>  '2019-01-20 20:00:00',
				'updated_at' =>  '2019-01-20 20:00:00',
			),

			array(
				'id' => 2,
				'name' => 'expert_test',
				'email' => 'testd4d@yopmail.com',
				'first_name' => 'Expert',
				'last_name' => 'Test',
				'email_verified_at' =>  '2019-01-22 11:17:16',
				'password' => bcrypt('qwert@123'),
				'remember_token' => null,
				'website_url' => null,
				'is_active' => '1',
				'is_active' => '1',
				'lower_price'   => '1',
				'medium_price'  => '3',
				'higher_price'  =>'5',
				'created_at' =>  '2019-01-20 20:00:00',
				'updated_at' =>  '2019-01-20 20:00:00',
			),
		);

		DB::table('users')->insert($userData);
	}
}
