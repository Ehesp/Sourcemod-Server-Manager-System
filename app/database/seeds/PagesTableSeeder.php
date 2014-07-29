<?php

class PagesTableSeeder extends Seeder {

    private function attach($page, $roles)
    {
        foreach ($roles as $role)
        {
            $page->roles()->attach($role['id']);
        }

        return;
    }

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

        $this->attach($page, Role::all());

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

        $this->attach($page, Role::all());

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

        $this->attach($page, Role::where('name', '!=', 'guest')->get());

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

        $this->attach($page, Role::where('name', 'super_admin')->get());

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

        $this->attach($page, Role::where('name', 'super_admin')->orWhere('name', 'admin')->get());

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

        $this->attach($page, Role::all());

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

        $this->attach($page, Role::where('name', 'super_admin')->get());
    }

}