<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Item::class;
    public function definition(): array
    {
        return [
            'kode_barang' => $this->faker->unique()->bothify('ITM-####'),
            'nama_barang' => $this->faker->word,
            'lokasi' => strtoupper($this->faker->bothify('L#-R#?')),
            'stok' => $this->faker->numberBetween(10, 100),
            'satuan' => $this->faker->randomElement(['pcs', 'box', 'pak']),
            'status' => $this->faker->randomElement(['diproses', 'terpenuhi', 'ditolak']),
        ];
    }
}
