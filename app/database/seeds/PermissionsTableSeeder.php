<?php

class PermissionsTableSeeder extends Seeder {

    public function run()
    {
        $this->seedServerPermissions();
        $this->seedActivePluginsPermissions();
        $this->seedMultiConsolePermissions();
        $this->seedAdminActivityPermissions();
        $this->seedSettingsPermissions();
    }

    private function attach($permission, $roles)
    {
        foreach ($roles as $role)
        {
            $permission->roles()->attach($role['id']);
        }

        return;
    }

    protected function seedServerPermissions()
    {
        $servers = Page::whereName('servers')->first(['id'])->id;

        // Add new server

        $permission = Permission::create([
            'name' => 'servers.add',
            'description' => 'Add a new server',
            'page_id' => $servers,
        ]);

        $this->attach($permission, Role::where('name', 'super_admin')->get());

        // Edit existing server

        $permission = Permission::create([
            'name' => 'servers.edit',
            'description' => 'Edit a server',
            'page_id' => $servers,
        ]);

        $this->attach($permission, Role::where('name', 'super_admin')->get());

        // Delete existing server

        $permission = Permission::create([
            'name' => 'servers.delete',
            'description' => 'Delete a server',
            'page_id' => $servers,
        ]);

        $this->attach($permission, Role::where('name', 'super_admin')->get());

        // Refresh server

        $permission = Permission::create([
            'name' => 'servers.refresh',
            'description' => 'Refresh a server or servers',
            'page_id' => $servers,
        ]);

        $this->attach($permission, Role::where('name', '!=', 'guest')->get());

        // Restart server

        $permission = Permission::create([
            'name' => 'servers.restart',
            'description' => 'Restart a server',
            'page_id' => $servers,
        ]);

        $this->attach($permission, Role::where('name', 'super_admin')->orWhere('name', 'admin')->get());

        // View server restarts

        $permission = Permission::create([
            'name' => 'servers.view_restarts',
            'description' => 'View server restarts',
            'page_id' => $servers,
        ]);

        $this->attach($permission, Role::where('name', 'super_admin')->orWhere('name', 'admin')->orWhere('name', 'user')->get());

        // Perform RCON commands

        $permission = Permission::create([
            'name' => 'servers.rcon',
            'description' => 'Perform RCON commands',
            'page_id' => $servers,
        ]);

        $this->attach($permission, Role::where('name', 'super_admin')->get());

        return $this;
    }

    protected function seedActivePluginsPermissions()
    {
        $plugins = Page::whereName('active_plugins')->first(['id'])->id;

        // View active plguins

        $permission = Permission::create([
            'name' => 'active_plugins.view',
            'description' => 'View plugins list',
            'page_id' => $plugins,
        ]);

        $this->attach($permission, Role::where('name', '!=', 'guest')->get());

        // Plugin updater function

        $permission = Permission::create([
            'name' => 'active_plugins.update',
            'description' => 'Update plugins function',
            'page_id' => $plugins,
        ]);

        $this->attach($permission, Role::where('name', 'super_admin')->orWhere('name', 'admin')->get());

        // Plugin checker function

        $permission = Permission::create([
            'name' => 'active_plugins.check',
            'description' => 'Use plugin checker',
            'page_id' => $plugins,
        ]);

        $this->attach($permission, Role::where('name', 'super_admin')->orWhere('name', 'admin')->get());

        return $this;

    }

    protected function seedMultiConsolePermissions()
    {
        $console = Page::whereName('multi_console')->first(['id'])->id;

        // Execute console commands

        $permission = Permission::create([
            'name' => 'multi_console.execute',
            'description' => 'Execute commands via multi-console',
            'page_id' => $console,
        ]);

        $this->attach($permission, Role::where('name', 'super_admin')->get());

        return $this;

    }

    protected function seedAdminActivityPermissions()
    {
        $activity = Page::whereName('admin_activity')->first(['id'])->id;

        // View admin activity

        $permission = Permission::create([
            'name' => 'admin_activity.view',
            'description' => 'View admin activity',
            'page_id' => $activity,
        ]);

        $this->attach($permission, Role::where('name', 'super_admin')->orWhere('name', 'admin')->get());

        return $this;     
    }

    protected function seedSettingsPermissions()
    {
        $settings = Page::whereName('settings')->first(['id'])->id;

        // Manage users page

        $permission = Permission::create([
            'name' => 'settings.users',
            'description' => 'View user management page',
            'page_id' => $settings,
        ]);

        $this->attach($permission, Role::where('name', 'super_admin')->orWhere('name', 'admin')->get());

        // Add new user

        $permission = Permission::create([
            'name' => 'settings.users.add',
            'description' => 'Add a new user',
            'page_id' => $settings,
        ]);

        $this->attach($permission, Role::where('name', 'super_admin')->get());

        // Edit a user

        $permission = Permission::create([
            'name' => 'settings.users.edit',
            'description' => 'Edit existing user',
            'page_id' => $settings,
        ]);

        $this->attach($permission, Role::where('name', 'super_admin')->get());

        // Delete a user

        $permission = Permission::create([
            'name' => 'settings.users.delete',
            'description' => 'Delete existing user',
            'page_id' => $settings,
        ]);

        $this->attach($permission, Role::where('name', 'super_admin')->get());

        // Refresh a user(s)

        $permission = Permission::create([
            'name' => 'settings.users.refresh',
            'description' => 'Refresh a user(s)',
            'page_id' => $settings,
        ]);

        $this->attach($permission, Role::where('name', 'super_admin')->get());

        // Manage SSMS options

        $permission = Permission::create([
            'name' => 'settings.options',
            'description' => 'Manage application options',
            'page_id' => $settings,
        ]);

        $this->attach($permission, Role::where('name', 'super_admin')->get());

        // Manage quick links

        $permission = Permission::create([
            'name' => 'settings.quick_links',
            'description' => 'Manage application quick links',
            'page_id' => $settings,
        ]);

        $this->attach($permission, Role::where('name', 'super_admin')->orWhere('name', 'admin')->get());

        // Manage page access control

        $permission = Permission::create([
            'name' => 'settings.page_management',
            'description' => 'Manage pages and their access',
            'page_id' => $settings,
        ]);

        $this->attach($permission, Role::where('name', 'super_admin')->get());

        // Manage permmission control

        $permission = Permission::create([
            'name' => 'settings.permission_control',
            'description' => 'Manage application permissions',
            'page_id' => $settings,
        ]);

        $this->attach($permission, Role::where('name', 'super_admin')->get());

        // Manage triggers

        $permission = Permission::create([
            'name' => 'settings.notifications',
            'description' => 'Manage application notifications',
            'page_id' => $settings,
        ]);

        $this->attach($permission, Role::where('name', 'super_admin')->get());

        return $this;
    }

}