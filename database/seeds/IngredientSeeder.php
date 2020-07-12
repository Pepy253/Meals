<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use App\Ingredient;
use App\Language;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::Create('App\Ingredient');
        $langId = Language::where('slug', '=', 'en')->get();
        $faker->addProvider(new \FakerRestaurant\Provider\en_US\Restaurant($faker));

        for ($i = 0; $i < 10; $i++) {
            $name[] = $faker->vegetableName();
        }

        $ingredients = array_unique($name);

        foreach ($ingredients as $ingredient) {
            $data = [
                'slug' => Str::slug($ingredient, '_'),
                'created_at' => $faker->dateTimeThisDecade($max = '-1 years', $timezone = null),
                'updated_at' => $faker->dateTimeThisYear($max = '-1 months', $timezone = null),
                    'en' => [
                        'language_id' => $langId[0]->id,
                        'title' => $ingredient,
                    ],

            ];
            Ingredient::create($data);
        }
    }
}
