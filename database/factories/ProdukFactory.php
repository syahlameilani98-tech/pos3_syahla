<?php

namespace Database\Factories;

use App\Models\produk;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends Factory<produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $hargaBeli = $this->faker->numberBetween(10_000, 500_000);
        return [
            'user_id'=>User::where('Role_id', 1)->inRandomOrder()->value('id'),
            'foto' => 'Produk/' .$this->faker->uuid . 'jpg',
            'name' => $this->faker->words(3, true),
            'harga_beli' => $hargaBeli,
            'harga_jual' => $hargaBeli + $this->faker->numberBetween(5_000, 100_000),
            'stok' => $this->faker->numberBetween(1, 500),
        ];
    }
}
