<?php

class GameTypesTableSeeder extends Seeder {

    public function run()
    {
        GameType::create([
            'client_appid' => 440,
            'hldsid' => 'tf',
            'gamename' => 'Team Fortress 2',
            'version' => '2316884',
            'icon' => 'e3f595a92552da3d664ad00277fad2107345f743.jpg',
            'logo' => '07385eb55b5ba974aebbe74d3c99626bda7920b8.jpg',
        ]);

        GameType::create([
            'client_appid' => 500,
            'hldsid' => 'left4dead',
            'gamename' => 'Left 4 Dead',
            'version' => '1.0.2.8',
            'icon' => '428df26bc35b09319e31b1ffb712487b20b3245c.jpg',
            'logo' => '0f67ee504d8f04ecd83986dd7855821dc21f7a78.jpg',
        ]);

        GameType::create([
            'client_appid' => 550,
            'hldsid' => 'left4dead2',
            'gamename' => 'Left 4 Dead 2',
            'version' => '2.1.3.6',
            'icon' => '7d5a243f9500d2f8467312822f8af2a2928777ed.jpg',
            'logo' => '205863cc21e751a576d6fff851984b3170684142.jpg',
        ]);

        GameType::create([
            'client_appid' => 300,
            'hldsid' => 'dod',
            'gamename' => 'Day of Defeat: Source',
            'version' => '1.0.0.30',
            'icon' => '062754bb5853b0534283ae27dc5d58200692b22d.jpg',
            'logo' => 'e3a4313690bd551495a88e1c01951eb26cec7611.jpg',
        ]);

        GameType::create([
            'client_appid' => 17710,
            'hldsid' => 'nucleardawn',
            'gamename' => 'Nuclear Dawn',
            'version' => '13.02.13',
            'icon' => '77c685357c1fb6b0127bce460b4c4ad40ee5ee33.jpg',
            'logo' => '05786499d3c7b3ed842936f29bbc3b753664936d.jpg',
        ]);
        
        GameType::create([
            'client_appid' => 240,
            'hldsid' => 'cstrike',
            'gamename' => 'Counter-Strike: Source',
            'version' => '2230303',
            'icon' => '9052fa60c496a1c03383b27687ec50f4bf0f0e10.jpg',
            'logo' => 'ee97d0dbf3e5d5d59e69dc20b98ed9dc8cad5283.jpg',
        ]);

        GameType::create([
            'client_appid' => 730,
            'hldsid' => 'csgo',
            'gamename' => 'Counter-Strike: Global Offensive',
            'version' => '1.34.1.1',
            'icon' => '69f7ebe2735c366c65c0b33dae00e12dc40edbe4.jpg',
            'logo' => 'd0595ff02f5c79fd19b06f4d6165c3fda2372820.jpg',
        ]);

        GameType::create([
            'client_appid' => 265630,
            'hldsid' => 'fof',
            'gamename' => 'Fistful of Frags',
            'version' => '',
            'icon' => 'e70c19e10125ea3f221666327af2b90f3fcecad9.jpg',
            'logo' => '45ba88467785ebd77384e4b386abac1bfdad785b.jpg',
        ]);
    }

}