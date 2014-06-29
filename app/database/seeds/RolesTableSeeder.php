<?php

class RolesTableSeeder extends Seeder {

    public function run()
    {
        Role::create([
        	'name' => 'super_admin',
        	'friendly_name' => 'Super Admin',
        ]);

		Role::create([
			'name' => 'admin',
			'friendly_name' => 'Admin',
		]);

        Role::create([
            'name' => 'user',
            'friendly_name' => 'User',
        ]);

        Role::create([
            'name' => 'guest',
            'friendly_name' => 'Guest',
        ]);
    }

}