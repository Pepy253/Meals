<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Meal extends Model implements TranslatableContract
{
    use Translatable;
    use SoftDeletes;
    
    public $translatedAttributes = ['title', 'description'];
    protected $fillable = ['slug', 'created_at', 'updated_at'];
    protected $hidden = ['pivot', 'translations', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'meal_ingredients');

    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'meal_tags');
    }

}
