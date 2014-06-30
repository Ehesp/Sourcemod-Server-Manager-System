<?php

class OptionsTableSeeder extends Seeder {

    public function run()
    {
        Option::create([
            'name' => 'default_language',
            'friendly_name' => 'Default Language',
            'value' => 'en',
            'options' => "['en', 'nl', 'de']",
            'description' => 'If no language is set by the user, this is the default',
        ]);

        Option::create([
            'name' => 'application_title',
            'friendly_name' => 'Application Title',
            'value' => 'SSMS',
            'description' => 'The title used in various places around the application',
        ]);

        Option::create([
            'name' => 'theme',
            'friendly_name' => 'Theme',
            'value' => 'blue',
            'options' => "['blue', 'red', 'orange', 'green']",
            'description' => 'The colour theme the application',
        ]);
    }

}