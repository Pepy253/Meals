<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Meal;
use App\Language;

class MealTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('App\MealTranslation');
        $meals = Meal::withTrashed()->get();
        $langId = Language::where('slug', '!=', 'en')->get();
        
        foreach ($meals as $meal) {
            $desc = $meal->translate('en')->description;
            $title = $meal->translate('en')->title;

            foreach ($langId as $lang) {
                DB::table('meal_translations')->insert([
                    'meal_id' => $meal->id,
                    'language_id' => $lang->id,
                    'locale' => $lang->slug,
                    'title' => GoogleTranslate::trans($title, $lang->slug),
                    'description' => GoogleTranslate::trans($desc, $lang->slug)
                ]);
            }
        }
    }
}
