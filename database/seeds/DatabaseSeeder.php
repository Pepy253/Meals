<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            LanguageSeeder::class,
            CategorySeeder::class,
            CategoryTranslationSeeder::class,
            MealSeeder::class,
            MealTranslationSeeder::class,
            IngredientSeeder::class,
            IngredientTranslationSeeder::class,
            TagSeeder::class,
            TagTranslationSeeder::class,
            MealIngredientSeeder::class,
            MealTagSeeder::class
        ]);
    }
}
