<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Event::factory(100)->create();
        foreach (Event::cursor() as $event) {
            $event->name = "Event-" . $event->id;
            Event::query()->find($event->id)->update(["name"=>$event->name]);
        }
    }
}
