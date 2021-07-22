<?php

use Illuminate\Database\Seeder;

class Role extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        	DB::table('roles')->delete();
		
		
		$roleData = array(
							array(
									'id' => 1,
									'name' => 'admin',
									'display_name' => 'Admin',
									'description' =>  'This is super admin role for login',
									'created_at' =>  '2019-04-26 17:00:00',
									'updated_at' =>  '2019-04-26 17:00:00',
							),
				
							array(	'id' =>2,
									'name' => 'expert',
									'display_name' => 'Expert',
									'description' => 'expert role',
									'created_at' =>  '2019-04-26 17:00:00',
									'updated_at' =>  '2019-04-26 17:00:00',
							),

							array(	'id' =>3,
									'name' => 'user',
									'display_name' => 'User',
									'description' => 'user role',
									'created_at' =>  '2019-04-26 17:00:00',
									'updated_at' =>  '2019-04-26 17:00:00',
							),
						
					);
		
		
		DB::table('roles')->insert($roleData);
    }
}
