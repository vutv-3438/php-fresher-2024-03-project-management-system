<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\WorkFlow;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkFlowStepFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $index = 0;
        return [
            'name' => $this->faker->name,
            'order' => ++$index,
            'description' => $this->faker->text,
            'work_fLow_id' => function () {
                return self::factoryForModel(WorkFlow::class)->create()->id;
            },
        ];
    }
}
