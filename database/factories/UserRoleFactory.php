<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserRoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'role_id' => function () {
                return self::factoryForModel(Role::class)->create()->id;
            },
            'user_id' => function () {
                return self::factoryForModel(User::class)->create()->id;
            },
        ];
    }
}
