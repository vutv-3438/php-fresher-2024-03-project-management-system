<?php

namespace Database\Factories;

use App\Models\WorkFlow;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkFlowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text,
            'description' => $this->faker->text,
            'project_id' => null,
        ];
    }

    public function withProject(int $id): WorkFlowFactory
    {
        return $this->state([
            'project_id' => $id
        ]);
    }
}
