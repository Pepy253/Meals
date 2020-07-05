<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use App\Meal;
use App\Language;

class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('App\Meal');
        $faker->addProvider(new \FakerRestaurant\Provider\en_US\Restaurant($faker));

        $categories = DB::table('categories')->get();
        $langId = Language::where('slug', '=', 'en')->get();
        
        for($i = 0; $i < 35; $i++)
        {
            $name[] = $faker->foodName();
        }

        $food = array_unique($name);

        foreach($food as $f)
        {
            $rnd = rand(0, 100);

            if($rnd < 80)
            {
                $deleted = null;
            }
            else
            {
                $deleted = $faker->dateTimeThisMonth($max = 'now', $timezone = null);
            }

            if($rnd < 50)
            {
                $updated = $faker->dateTimeThisYear($max = '-1 months', $timezone = null);
                $catId = rand($categories[0]->id, $categories[(count($categories)-1)]->id);
            }
            else
            {
                $updated = null;
                $catId = null;    
            }

            $data = [
                'slug' => Str::slug($f, '_'),
                'category_id' => $catId,
                'created_at' => $faker->dateTimeThisDecade($max = '-1 years', $timezone = null),
                'updated_at' => $updated,
                'deleted_at' => $deleted,
                    'en' => [
                        'language_id' => $langId[0]->id,
                        'description' => $faker->realText($maxNbChars = 50, $indexSize = 2),
                        'title' => $f
                    ]
                
            ];
            Meal::create($data);
        }
    }
}
