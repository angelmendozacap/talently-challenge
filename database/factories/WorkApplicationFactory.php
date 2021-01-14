<?php

namespace Database\Factories;

use App\Models\Phase;
use App\Models\WorkApplication;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WorkApplication::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(2, true),
            'company' => $this->faker->company,
            'description' => $this->faker->sentences(3, true),
            'phase_id' => Phase::factory(),
            'application_date' => $this->faker->date(),
        ];
    }
}
