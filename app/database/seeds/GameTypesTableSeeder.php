<?php

class GameTypesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('game_types')->insert([
            'name' => 'Team Fortress 2',
            'acronym' => 'tf2',
            'app_id' => 440,
            'version' => '2316884',
            'min_players' => 4,
            'icon' => 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/440/e3f595a92552da3d664ad00277fad2107345f743.jpg',
            'logo' => 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/440/07385eb55b5ba974aebbe74d3c99626bda7920b8.jpg',
            'logo_thumb' => 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/440/07385eb55b5ba974aebbe74d3c99626bda7920b8_thumb.jpg',

        ]);

         DB::table('game_types')->insert([
            'name' => 'Counter-Strike: Source',
            'acronym' => 'css',
            'app_id' => 240,
            'version' => '2230303',
            'min_players' => 4,
        ]);

        DB::table('game_types')->insert([
            'name' => 'Counter-Strike: Global Offensive',
            'acronym' => 'csgo',
            'app_id' => 730,
            'version' => '1.34.1.1',
            'min_players' => 4,
        ]);

        DB::table('game_types')->insert([
            'name' => 'Day of Defeat: Source',
            'acronym' => 'dod',
            'app_id' => 300,
            'version' => '1.0.0.30'
        ]);

        DB::table('game_types')->insert([
            'name' => 'Left 4 Dead',
            'acronym' => 'l4d',
            'app_id' => 500,
            'version' => '1.0.2.8'
        ]);

        DB::table('game_types')->insert([
            'name' => 'Left 4 Dead 2',
            'acronym' => 'l4d2',
            'app_id' => 550,
            'version' => '2.1.3.6'
        ]);

        DB::table('game_types')->insert([
            'name' => 'Nuclear Dawn',
            'acronym' => 'nd',
            'app_id' => 17710,
            'version' => '13.02.13'
        ]);

    }

}