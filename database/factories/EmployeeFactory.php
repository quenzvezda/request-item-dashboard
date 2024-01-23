<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Employee::class;
    public function definition(): array
    {
        $department = Department::factory()->create();
        $user = User::factory()->create();

        return [
            'nik' => $this->faker->unique()->numerify('001.0##.#####'),
            'nama' => $this->faker->name,
            'departmen_id' => $department->id,
            'user_id' => $user->id,
        ];
    }
}
