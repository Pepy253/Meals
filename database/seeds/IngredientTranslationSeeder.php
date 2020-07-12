<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Stichoza\GoogleTranslate\GoogleTranslate;

class IngredientTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::Create('App\Ingredient');
        $ingredients = DB::table('ingredients')->get();
        $languages = DB::table('languages')->where('slug', '!=', 'en')->get();


        foreach ($ingredients as $ingredient) {
            foreach ($languages as $language) {
                $title = ucfirst(str_replace('_', ' ', $ingredient->slug));

                DB::table('ingredient_translations')->insert([
                    'ingredient_id' => $ingredient->id,
                    'language_id' => $language->id,
                    'locale' => $language->slug,
                    'title' => GoogleTranslate::trans($title, $language->slug)
                ]);
            }
        }
    }
}
