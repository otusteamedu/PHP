<?php

namespace Database\Seeders;

use App\Models\Channel;
use App\Models\ChannelVideo;
use Illuminate\Database\Seeder;

class ChannelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Channel::query()->truncate();
        Channel::withoutEvents(function () {
            Channel::factory(50)
                ->has(ChannelVideo::factory(rand(3, 7)), 'videos')
                ->create();
        });
    }
}
