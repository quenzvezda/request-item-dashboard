<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\ItemRequest;
use App\Models\ItemRequestDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ItemRequest>
 */
class ItemRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = ItemRequest::class;
    public function definition(): array
    {
        return [
            'employee_id' => Employee::factory(),
            'tanggal_permintaan' => $this->faker->date(),
        ];
    }

    public function forUser($userId)
    {
        return $this->state(function () use ($userId){
            return ['user_id' => $userId];
        });
    }

    public function configure()
    {
        return $this->afterCreating(function (ItemRequest $itemRequest){
            ItemRequestDetail::factory(rand(1, 5))->create([
                'item_request_id' => $itemRequest->id,
            ]);
        });
    }
}
