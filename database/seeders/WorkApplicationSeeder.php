<?php

namespace Database\Seeders;

use App\Models\WorkApplication;
use Illuminate\Database\Seeder;

class WorkApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WorkApplication::factory()->times(3)->create(['phase_id' => 1, 'user_id' => 1]);
        WorkApplication::factory()->times(2)->create(['phase_id' => 2, 'user_id' => 1]);
        WorkApplication::factory()->times(5)->create(['phase_id' => 3, 'user_id' => 1]);
        WorkApplication::factory()->create(['phase_id' => 4, 'user_id' => 1]);

        WorkApplication::factory()->times(4)->create(['phase_id' => 1]);
        WorkApplication::factory()->times(5)->create(['phase_id' => 2]);
        WorkApplication::factory()->times(6)->create(['phase_id' => 3]);
        WorkApplication::factory()->times(4)->create(['phase_id' => 4]);
    }
}
