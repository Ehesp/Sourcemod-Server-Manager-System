<?php

class QuickLinksTableSeeder extends Seeder {

    public function run()
    {
        DB::table('quick_links')->create([
            'name' => 'Forums',
            'url' => 'http://lethal-zone.eu/forum',
            'icon' => 'fa fa-external-link',
        ]);

        DB::table('quick_links')->create([
            'name' => 'IRC',
            'url' => 'http://webchat.quakenet.org/?randomnick=1&channels=lethalzone',
            'icon' => 'fa fa-comment',
        ]);
    }

}