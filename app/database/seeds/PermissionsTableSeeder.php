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

    protected function seedServerPermissions()
    {
        $servers = Page::whereName('servers')->first(['id'])->id;

        // View server list

        $permission = Permission::create([
            'name' => 'servers.view',
            'page_id' => $servers,
        ]);

        $permission->assignRoles(
            Role::all()
        );

        // Add new server

        $permission = Permission::create([
            'name' => 'servers.new',
            'page_id' => $servers,
        ]);

        $permission->assignRoles(
            Role::where('name', 'super_admin')->get()
        );

        // Edit existing server

        $permission = Permission::create([
            'name' => 'servers.edit',
            'page_id' => $servers,
        ]);

        $permission->assignRoles(
            Role::where('name', 'super_admin')->get()
        );

        // Delete existing server

        $permission = Permission::create([
            'name' => 'servers.delete',
            'page_id' => $servers,
        ]);

        $permission->assignRoles(
            Role::where('name', 'super_admin')->get()
        );

        // Refresh server

        $permission = Permission::create([
            'name' => 'servers.refresh',
            'page_id' => $servers,
        ]);

        $permission->assignRoles(
            Role::where('name', '!=', 'guest')->get()
        );

        // Restart server

        $permission = Permission::create([
            'name' => 'servers.restart',
            'page_id' => $servers,
        ]);

        $permission->assignRoles(
            Role::where('name', 'super_admin')->orWhere('name', 'admin')->get()
        );

        // View server restarts

        $permission = Permission::create([
            'name' => 'servers.viewRestarts',
            'page_id' => $servers,
        ]);

        $permission->assignRoles(
            Role::where('name', 'super_admin')->orWhere('name', 'admin')->orWhere('name', 'user')->get()
        );

        // Perform RCON commands

        $permission = Permission::create([
            'name' => 'servers.rcon',
            'page_id' => $servers,
        ]);

        $permission->assignRoles(
            Role::where('name', 'super_admin')->get()
        );

        return $this;
    }

    protected function seedActivePluginsPermissions()
    {
        $plugins = Page::whereName('active_plugins')->first(['id'])->id;

        // View active plguins

        $permission = Permission::create([
            'name' => 'active_plugins.view',
            'page_id' => $plugins,
        ]);

        $permission->assignRoles(
            Role::where('name', '!=', 'guest')->get()
        );

        // Plugin updater function

        $permission = Permission::create([
            'name' => 'active_plugins.update',
            'page_id' => $plugins,
        ]);

        $permission->assignRoles(
            Role::where('name', 'super_admin')->orWhere('name', 'admin')->get()
        );

        // Plugin checker function

        $permission = Permission::create([
            'name' => 'active_plugins.check',
            'page_id' => $plugins,
        ]);

        $permission->assignRoles(
            Role::where('name', 'super_admin')->orWhere('name', 'admin')->get()
        );

        return $this;

    }

    protected function seedMultiConsolePermissions()
    {
        $console = Page::whereName('multi_console')->first(['id'])->id;

        // Execute console commands

        $permission = Permission::create([
            'name' => 'multi_console.execute',
            'page_id' => $console,
        ]);

        $permission->assignRoles(
            Role::where('name', 'super_admin')->get()
        );

        return $this;

    }

    protected function seedAdminActivityPermissions()
    {
        $activity = Page::whereName('admin_activity')->first(['id'])->id;

        // View admin activity

        $permission = Permission::create([
            'name' => 'admin_activity.view',
            'page_id' => $activity,
        ]);

        $permission->assignRoles(
            Role::where('name', 'super_admin')->orWhere('name', 'admin')->get()
        );       
    }

    protected function seedSettingsPermissions()
    {
        $settings = Page::whereName('settings')->first(['id'])->id;

        // Manage users page

        $permission = Permission::create([
            'name' => 'settings.users.manage',
            'page_id' => $settings,
        ]);

        $permission->assignRoles(
            Role::where('name', 'super_admin')->orWhere('name', 'admin')->get()
        );

        // Add new user

        $permission = Permission::create([
            'name' => 'settings.users.add',
            'page_id' => $settings,
        ]);

        $permission->assignRoles(
            Role::where('name', 'super_admin')->get()
        );

        // Edit a user

        $permission = Permission::create([
            'name' => 'settings.users.edit',
            'page_id' => $settings,
        ]);

        $permission->assignRoles(
            Role::where('name', 'super_admin')->get()
        );

        // Delete a user

        $permission = Permission::create([
            'name' => 'settings.users.delete',
            'page_id' => $settings,
        ]);

        $permission->assignRoles(
            Role::where('name', 'super_admin')->get()
        );

        // Manage SSMS options

        $permission = Permission::create([
            'name' => 'settings.options',
            'page_id' => $settings,
        ]);

        $permission->assignRoles(
            Role::where('name', 'super_admin')->get()
        );

        // Manage quick links

        $permission = Permission::create([
            'name' => 'settings.quicklinks',
            'page_id' => $settings,
        ]);

        $permission->assignRoles(
            Role::where('name', 'super_admin')->orWhere('name', 'admin')->get()
        );

        // Manage access control

        $permission = Permission::create([
            'name' => 'settings.access',
            'page_id' => $settings,
        ]);

        $permission->assignRoles(
            Role::where('name', 'super_admin')->get()
        );

        return $this;

    }

}