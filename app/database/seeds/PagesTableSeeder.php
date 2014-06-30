<?php

class PagesTableSeeder extends Seeder {

    public function run()
    {
        /**
        * Dashboard
        *
        */

        $page = Page::create([
        	'name' => 'dashboard',
            'friendly_name' => 'Dashboard',
            'icon' => 'fa fa-tachometer',
        	'slug' => 'dashboard',
        ]);

        $page->assignRoles(
            Role::all()
        );

        /**
        * Servers
        *
        */

        $page = Page::create([
            'name' => 'servers',
            'friendly_name' => 'Servers',
            'icon' => 'fa fa-tasks',
            'slug' => 'servers',
        ]);

        $page->assignRoles(
            Role::all()
        );

        /**
        * Active Plugins
        *
        */

        $page = Page::create([
            'name' => 'active_plugins',
            'friendly_name' => 'Active Plugins',
            'icon' => 'fa fa-sitemap',
            'slug' => 'active-plugins',
        ]);

        $page->assignRoles(
            Role::where('name', '!=', 'guest')->get()
        );

        /**
        * Multi Console
        *
        */

        $page = Page::create([
            'name' => 'multi_console',
            'friendly_name' => 'Multi-Console',
            'icon' => 'fa fa-terminal',
            'slug' => 'multi-console',
        ]);

        $page->assignRoles(
            Role::where('name', 'super_admin')->get()
        );

        /**
        * Admin Activity
        *
        */

        $page = Page::create([
            'name' => 'admin_activity',
            'friendly_name' => 'Admin Activity',
            'icon' => 'fa fa-comments',
            'slug' => 'admin-activity',
        ]);

        $page->assignRoles(
            Role::where('name', 'super_admin')->orWhere('name', 'admin')->get()
        );

        /**
        * Game Types
        *
        */

        $page = Page::create([
            'name' => 'game_types',
            'friendly_name' => 'Game Types',
            'icon' => 'fa fa-gamepad',
            'slug' => 'game-types',
        ]);

        $page->assignRoles(
            Role::all()
        );

        /**
        * Settings
        *
        */

        $page = Page::create([
            'name' => 'settings',
            'friendly_name' => 'Settings',
            'icon' => 'fa fa-cogs',
            'slug' => 'settings',
        ]);

        $page->assignRoles(
            Role::whereName('super_admin')->get()
        );
    }

}