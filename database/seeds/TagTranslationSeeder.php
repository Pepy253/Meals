<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class TagTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = DB::table('tags')->get();
        $languages = DB::table('languages')->where('slug', '!=', 'en')->get();
        $translations = array(
            array('Fruité', 'Fruchtig'),
            array('Doux', 'Süss'),
            array('Acide', 'Sauer'),
            array('Épicé', 'Würzig'),
        );
        
        for($i = 0; $i < count($tags); $i++)
        {
            for($j = 0; $j < count($languages); $j++)
            {
                DB::table('tag_translations')->insert([
                    'tag_id' => $tags[$i]->id,
                    'language_id' => $languages[$j]->id,
                    'locale' => $languages[$j]->slug,
                    'title' => $translations[$i][$j]
                ]);
            }
        }
    }
}
