<?php

namespace Database\Factories;

use App\Models\Medicines;
use App\Models\MedicinesDoses;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicinesDoses>
 */
class MedicinesDosesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'medicines_id' => Medicines::factory(),
            'amount' => fake()->randomFloat(2, 20, 200),
            'schedule' => Arr::random(MedicinesDoses::getAllSchedules()),
            'active' => fake()->boolean(75)
        ];
    }
}
