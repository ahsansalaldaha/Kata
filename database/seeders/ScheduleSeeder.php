<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Schedule;
use App\Models\Repeat;
use Exception;
use Illuminate\Support\Carbon;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $repeat = Repeat::every(1)->week()->first(['id']);
        $alternative_repeat = Repeat::every(2)->week()->first(['id']);
        if (!$repeat || !$alternative_repeat) {
            throw new Exception("Repeat Seeder needs to run", 422);
        }

        foreach (['Monday', 'Wednesday', 'Friday', 'Saturday'] as $day) {
            $schedule = Schedule::create([
                'day' => $day,
                'start' => Carbon::parse('08:00', 'Etc/UTC'),
                'end' => Carbon::parse('16:00', 'Etc/UTC'),
                'start_date' => Carbon::parse('2022-03-14', 'Etc/UTC'),
                'repeat_id' => $day == 'Saturday' ? $alternative_repeat->id : $repeat->id,
            ]);

            $schedule->breaks()->create([
                'start' => Carbon::parse('12:00', 'Etc/UTC'),
                'end' => Carbon::parse('12:45', 'Etc/UTC'),
            ]);
        }
    }
}
