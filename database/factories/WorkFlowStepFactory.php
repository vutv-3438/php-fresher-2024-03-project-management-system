<?php

namespace Database\Factories;

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
        return [
            'name' => $this->faker->text,
            'description' => $this->faker->text,
            'work_flow_id' => null,
            'order' => 1,
        ];
    }

    public function withWorkFlow(int $id): WorkFlowStepFactory
    {
        return $this->state([
            'work_flow_id' => $id
        ]);
    }
}
