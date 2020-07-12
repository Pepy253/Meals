<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Category;
use App\Language;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('App\Category');
        $langId = Language::where('slug', '=', 'en')->get();
        $categories = array('Appetizer', 'Soup', 'Sauce', 'Salad', 'Main course', 'Dessert');

        foreach ($categories as $category) {
            $data = [
                'slug' => Str::slug($category, '_'),
                'created_at' => $faker->dateTimeThisDecade($max = '-1 years', $timezone = null),
                'updated_at' => $faker->dateTimeThisYear($max = '-1 months', $timezone = null),
                    'en' => [
                        'language_id' => $langId[0]->id,
                        'title' => $category,
                    ],

            ];
            Category::create($data);
        }
    }
}
