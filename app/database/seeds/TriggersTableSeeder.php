<?php

class TriggersTableSeeder extends Seeder {

    public function run()
    {
        Trigger::create([
            'name' => 'retries',
            'friendly_name' => 'Retries Alert',
            'value' => '5',
            'options' => null,
            'description' => 'After this many minutes of not being able to connect to a server, issue an alert',
        ]);

        Trigger::create([
            'name' => 'hipchat.enabled',
            'friendly_name' => 'HipChat Enabled',
            'value' => 'false',
            'options' => 'true|false',
            'description' => 'Whether or not HipChat notifications are enabled',
        ]);

        Trigger::create([
            'name' => 'twitter.enabled',
            'friendly_name' => 'Twitter Enabled',
            'value' => 'false',
            'options' => 'true|false',
            'description' => 'Whether or not Twitter notifications are enabled',
        ]);

        Trigger::create([
            'name' => 'pushbullet.enabled',
            'friendly_name' => 'PushBullet Enabled',
            'value' => 'false',
            'options' => 'true|false',
            'description' => 'Whether or not PushBullet notifications are enabled',
        ]);
    }

}