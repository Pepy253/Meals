<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = array('French', 'German', 'English');
        $faker = Faker::create('App\Language');
        
        for ($i = 0; $i < count($languages); $i++) {
            $letter = str_split($languages[$i]);
            
            if ($languages[$i] == 'German') {
                $slug = 'de';
            } else {
                $slug = strtolower($letter[0]) . $letter[1];
            }
                                                         
            DB::table('languages')->insert([
                'title' => $languages[$i],
                'slug' => $slug,
                'created_at' => $faker->dateTimeThisDecade($max = 'now', $timezone = null),
                'updated_at' => $faker->dateTimeThisYear($max = 'now', $timezone = null),
            ]);
        }
    }
}
