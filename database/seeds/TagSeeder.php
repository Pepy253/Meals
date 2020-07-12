<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Tag;
use App\Language;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::Create('App\Tag');
        $langId = Language::where('slug', '=', 'en')->get();
        $tags = array('Fruity', 'Sweet', 'Sour', 'Spicy');

        foreach ($tags as $tag) {
            $data = [
                'slug' => Str::slug($tag, '_'),
                'created_at' => $faker->dateTimeThisDecade($max = '-1 years', $timezone = null),
                'updated_at' => $faker->dateTimeThisYear($max = '-1 months', $timezone = null),
                'en' => [
                    'language_id' => $langId[0]->id,
                    'title' => $tag
                ]
            ];

            Tag::create($data);
        }
    }
}
