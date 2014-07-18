<?php

class NotificationsTableSeeder extends Seeder {

    public function run()
    {
        Notification::create([
            'name' => 'retries',
            'friendly_name' => 'Server Retry Threshold',
            'value' => '5',
            'options' => null,
            'description' => 'After this many minutes of not being able to connect to a server, issue a notification',
        ]);

        Notification::create([
            'name' => 'email.enabled',
            'friendly_name' => 'E-Mail Notifications Enabled',
            'value' => 'false',
            'options' => 'true|false',
            'description' => 'Whether or not E-Mail notifications are enabled',
        ]);

        Notification::create([
            'name' => 'email.addresses',
            'friendly_name' => 'E-Mail Addresses',
            'value' => '',
            'options' => null,
            'description' => 'The email addresses that notifcations are sent to, seperated by a semi-colon (;)',
            'in_overview' => 0,
        ]);

        Notification::create([
            'name' => 'twitter.enabled',
            'friendly_name' => 'Twitter Notifications Enabled',
            'value' => 'false',
            'options' => 'true|false',
            'description' => 'Whether or not Twitter notifications are enabled',
        ]);

        Notification::create([
            'name' => 'twitter.key',
            'friendly_name' => 'Twitter Consumer Key',
            'value' => '',
            'options' => null,
            'description' => 'Your twitter account consumer key found on https://apps.twitter.com',
            'in_overview' => 0,
        ]);

        Notification::create([
            'name' => 'hipchat.enabled',
            'friendly_name' => 'HipChat Notifications Enabled',
            'value' => 'false',
            'options' => 'true|false',
            'description' => 'Whether or not HipChat notifications are enabled',
        ]);

        Notification::create([
            'name' => 'hipchat.room',
            'friendly_name' => 'HipChat Room ID',
            'value' => '',
            'options' => null,
            'description' => 'HipChat room ID to send notifications to',
            'in_overview' => 0,
        ]);

        Notification::create([
            'name' => 'hipchat.auth',
            'friendly_name' => 'HipChat Room Auth Token',
            'value' => '',
            'options' => null,
            'description' => 'The HipChat rooms auth token',
            'in_overview' => 0,
        ]);

        Notification::create([
            'name' => 'pushbullet.enabled',
            'friendly_name' => 'PushBullet Notifications Enabled',
            'value' => 'false',
            'options' => 'true|false',
            'description' => 'Whether or not PushBullet notifications are enabled',
        ]);
    }

}