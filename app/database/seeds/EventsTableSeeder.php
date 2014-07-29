<?php

class EventsTableSeeder extends Seeder {

    public function run()
    {
        $this->seedSettingActivity();
        $this->seedServerActivity();
    }

    private function attach($event, $services)
    {
        foreach ($services as $service)
        {
            $event->services()->attach($service['id']);
        }

        return;
    }

    protected function seedSettingActivity()
    {
        $event = Ssms\Event::create([
            'name' => 'setting.user.add',
            'description' => 'When a new user is added',
        ]);

        $this->attach($event, Service::whereName('hipchat')->get());

        $event = Ssms\Event::create([
            'name' => 'setting.user.delete',
            'description' => 'When a user is deleted',
        ]);

        $this->attach($event, Service::whereName('hipchat')->get());

        return $this;
    }

    protected function seedServerActivity()
    {
        $event = Ssms\Event::create([
            'name' => 'server.up',
            'description' => 'When a server is back up after being down',
        ]);

        $this->attach($event, Service::all());

        $event = Ssms\Event::create([
            'name' => 'server.down',
            'description' => 'When a server is down (retry threshold breached)',
        ]);

        $this->attach($event, Service::all());

        $event = Ssms\Event::create([
            'name' => 'server.updating',
            'description' => 'When a server is updating',
        ]);

        $this->attach($event, Service::where('name', 'email')->orWhere('name', 'hipchat')->get());

        $event = Ssms\Event::create([
            'name' => 'server.restart',
            'description' => 'When a server is restarting',
        ]);

        $this->attach($event, Service::whereName('hipchat')->get());
    }
}