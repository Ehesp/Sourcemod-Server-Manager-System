<?php

class RolesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('roles')->truncate();

        Role::create([
        	'name' => 'super_admin',
        	'friendly_name' => 'Super Admin',
        ]);

		Role::create([
			'name' => 'admin',
			'friendly_name' => 'Admin',
		]);
    }

}