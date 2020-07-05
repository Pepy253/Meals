<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Category;


class CategoryTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = DB::table('languages')->where('slug', '!=', 'en')->get();
        $category = Category::all();
        $translations = array(
            array('Apéritif', 'Vorspeise', 'Appetizer'),
            array('Soupe', 'Suppe', 'Soup'),
            array('Sauce', 'Soße', 'Sauce'),
            array('Salade', 'Salat', 'Salad'),
            array('Plat principal', 'Hauptkurs', 'Main course'),
            array('Dessert', 'Dessert', 'Dessert'),      
        );

        for($i = 0; $i < count($category); $i++)
        {
            for($j = 0; $j < count($languages); $j++)
            {
                DB::table('category_translations')->insert([
                    'category_id' => $category[$i]->id,
                    'language_id' => $languages[$j]->id,
                    'locale' => $languages[$j]->slug,
                    'title' => $translations[$i][$j]
                ]);
            }
        }
    }
}
