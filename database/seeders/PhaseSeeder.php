<?php

namespace Database\Seeders;

use App\Models\Phase;
use Illuminate\Database\Seeder;

class PhaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Phase::factory()->create(['display_name' => $name = 'Whishlist', 'name' => strtoupper($name)]);
        Phase::factory()->create(['display_name' => $name = 'Aplicado', 'name' => strtoupper($name)]);
        Phase::factory()->create(['display_name' => $name = 'Entrevista Técnica', 'name' => strtoupper($name)]);
        Phase::factory()->create(['display_name' => $name = 'Aceptado', 'name' => strtoupper($name)]);
    }
}
