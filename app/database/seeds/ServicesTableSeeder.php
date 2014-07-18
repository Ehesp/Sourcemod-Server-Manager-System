<?php

class ServicesTableSeeder extends Seeder {

    public function run()
    {
        Service::create([
        	'name' => 'email',
        	'friendly_name' => 'E-Mail',
        ]);

		Service::create([
			'name' => 'twitter',
			'friendly_name' => 'Twitter',
		]);

        Service::create([
            'name' => 'hipchat',
            'friendly_name' => 'HipChat',
        ]);

        Service::create([
            'name' => 'pushbullet',
            'friendly_name' => 'PushBullet',
        ]);
    }

}