<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class MealTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = DB::table('tags')->get();
        $meals = DB::table('meals')->get();

        foreach($meals as $meal)
        {
            foreach($tags as $tag)
            {
                $rnd = rand(0, 100);

                if($rnd < 70)
                {
                    DB::table('meal_tags')->insert([
                        'meal_id' => $meal->id,
                        'tag_id' => $tag->id
                    ]);
                }
                else
                {
                    continue;
                }
            }
        }
    }
}
