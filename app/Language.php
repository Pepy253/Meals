<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_translations')->withPivot('title');
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'ingredient_translations')->withPivot('title');
    }

    public function meals()
    {
        return $this->belongsToMany(Meal::class, 'meal_translations')->withPivot('title', 'decription');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_translations')->withPivot('title');
    }
}
