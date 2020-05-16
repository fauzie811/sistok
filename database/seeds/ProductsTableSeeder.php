<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        factory(App\Product::class, 50)->create()->each(function ($product) use ($faker) {
            $date = $faker->dateTimeBetween('-1 years');
            $type = 'in';
            $price = $type == 'in' ? $product->price * $faker->randomFloat(2, 0.7, 0.9) : $product->price;
            $quantity = $faker->numberBetween(10, 20);

            $product->transactions()->create(compact(['date', 'type', 'price', 'quantity']));

            for ($i=0; $i < $faker->randomDigitNotNull; $i++) { 
                $date = $faker->dateTimeBetween('-1 years');
                $type = $faker->randomElement(['in', 'out']);
                $price = $type == 'in' ? $product->price * $faker->randomFloat(2, 0.7, 0.9) : $product->price;
                $quantity = $faker->randomDigitNotNull;
    
                $product->transactions()->create(compact(['date', 'type', 'price', 'quantity']));
            }
        });
    }
}
