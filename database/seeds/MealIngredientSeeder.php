<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MealIngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ingredients = DB::table('ingredients')->get();
        $meals = DB::table('meals')->get();

        foreach ($meals as $meal) {
            foreach ($ingredients as $ingredient) {
                $rnd = rand(0, 100);

                if ($rnd < 50) {
                    DB::table('meal_ingredients')->insert([
                        'meal_id' => $meal->id,
                        'ingredient_id' => $ingredient->id
                    ]);
                } else {
                    continue;
                }
            }
        }
    }
}
