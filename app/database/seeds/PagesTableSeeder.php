<?php

class PagesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('pages')->truncate();

        $page = Page::create([
        	'name' => 'dashboard',
            'friendly_name' => 'Dashboard',
            'icon' => 'fa fa-tachometer',
        	'slug' => 'dashboard',
        ]);

        $page->assignRole(
            Role::whereName('super_admin')->first()
        );

        $page = Page::create([
            'name' => 'servers',
            'friendly_name' => 'Servers',
            'icon' => 'fa fa-tasks',
            'slug' => 'servers',
        ]);

        $page->assignRole(
            Role::whereName('super_admin')->first()
        );

        $page = Page::create([
            'name' => 'active_plugins',
            'friendly_name' => 'Active Plugins',
            'icon' => 'fa fa-sitemap',
            'slug' => 'active-plugins',
        ]);

        $page->assignRole(
            Role::whereName('super_admin')->first()
        );

        $page = Page::create([
            'name' => 'multi_console',
            'friendly_name' => 'Multi-Console',
            'icon' => 'fa fa-terminal',
            'slug' => 'multi-console',
        ]);

        $page->assignRole(
            Role::whereName('super_admin')->first()
        );

        $page = Page::create([
            'name' => 'admin_activity',
            'friendly_name' => 'Admin Activity',
            'icon' => 'fa fa-comments',
            'slug' => 'admin-activity',
        ]);

        $page->assignRole(
            Role::whereName('super_admin')->first()
        );

        $page = Page::create([
            'name' => 'game_types',
            'friendly_name' => 'Game Types',
            'icon' => 'fa fa-comments',
            'slug' => 'game-types',
        ]);

        $page->assignRole(
            Role::whereName('super_admin')->first()
        );

        $page = Page::create([
            'name' => 'settings',
            'friendly_name' => 'Settings',
            'icon' => 'fa fa-cogs',
            'slug' => 'settings',
        ]);

        $page->assignRole(
            Role::whereName('super_admin')->first()
        );
    }

}