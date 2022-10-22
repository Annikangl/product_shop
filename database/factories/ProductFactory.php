<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        // TODO make custom provider
        $imagesDir = Storage::makeDirectory('images/products');

        return [
            'title' => ucfirst($this->faker->words(2, true)),
            'brand_id' => Brand::query()->inRandomOrder()->value('id'),
            'price' => $this->faker->numberBetween(999, 100000),
            'thumbnail' => $this->faker->file(
                base_path() . '/tests/Fixtures/images/products',
                storage_path() . '/app/public/images/products',
                false
            )
        ];
    }
}
