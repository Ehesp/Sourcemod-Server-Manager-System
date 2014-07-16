<?php

class FlagsTableSeeder extends Seeder {

    public function run()
    {
        Flag::create([
            'icon' => 'fa fa-check',
            'type' => 'success',
            'message' => 'All OK!',
        ]);

        Flag::create([
            'icon' => 'fa fa-spinner fa-spin',
            'type' => 'info',
            'message' => 'Server is currently restarting!',
        ]);

        Flag::create([
            'icon' => 'fa-cloud-download',
            'type' => 'info',
            'message' => 'Server is currently updating!',
        ]);

        Flag::create([
            'icon' => 'fa fa-exclamation-triangle',
            'type' => 'warning',
            'message' => 'The current RCON password is incorrect for this server!',
        ]);

        Flag::create([
            'icon' => 'fa fa-eye',
            'type' => 'warning',
            'message' => 'Failed to connect to server on latest refresh - server may be changing maps!',
        ]);

        Flag::create([
            'icon' => 'fa fa-exclamation',
            'type' => 'error',
            'message' => 'Server down - the retries count has been breached!',            
        ]);
    }

}