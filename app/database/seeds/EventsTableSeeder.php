<?php

class EventsTableSeeder extends Seeder {

    public function run()
    {
        $this->seedSettingActivity();
        $this->seedServerActivity();
    }

    protected function seedSettingActivity()
    {
        $event = Ssms\Event::create([
            'name' => 'setting.user.add',
            'description' => 'When a new user is added',
        ]);

        $event->assignServices(
            Service::whereName('hipchat')->get()
        );

        $event = Ssms\Event::create([
            'name' => 'setting.user.delete',
            'description' => 'When a user is deleted',
        ]);

        $event->assignServices(
            Service::whereName('hipchat')->get()
        );

        return $this;
    }

    protected function seedServerActivity()
    {
        $event = Ssms\Event::create([
            'name' => 'server.up',
            'description' => 'When a server is back up after being down',
        ]);

        $event->assignServices(
            Service::all()
        );

        $event = Ssms\Event::create([
            'name' => 'server.down',
            'description' => 'When a server is down (retry threshold breached)',
        ]);

        $event->assignServices(
            Service::all()
        );

        $event = Ssms\Event::create([
            'name' => 'server.updating',
            'description' => 'When a server is updating',
        ]);

        $event->assignServices(
            Service::where('name', 'email')->orWhere('name', 'hipchat')->get()
        );

        $event = Ssms\Event::create([
            'name' => 'server.restart',
            'description' => 'When a server is restarting',
        ]);

        $event->assignServices(
            Service::whereName('hipchat')->get()
        );
    }
}