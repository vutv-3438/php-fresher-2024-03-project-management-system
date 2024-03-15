<?php

namespace Database\Factories;

use DragonCode\Support\Facades\Helpers\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProjectFactory extends Factory
{
    private $projectTypes = [
        'scrum',
        'kanban',
        'bug',
        'empty',
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $projectName = $this->faker->name;
        $startDate = $this->faker->dateTime;

        return [
            'name' => $projectName,
            'key' => strtoupper(Str::slug($projectName)),
            'description' => $this->faker->text,
            'start_date' => $startDate,
            'end_date' => Carbon::parse($startDate)->addMonth(),
            'type' => $this->projectTypes[array_rand($this->projectTypes)]
        ];
    }
}
