<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\ItemRequest;
use App\Models\ItemRequestDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ItemRequestDetail>
 */
class ItemRequestDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = ItemRequestDetail::class;
    public function definition(): array
    {
        return [
            'item_request_id' => ItemRequest::factory(),
            'item_id' => Item::factory(),
            'kuantitas' => $this->faker->numberBetween(1, 10),
            'keterangan' => $this->faker->sentence,
        ];
    }
}
