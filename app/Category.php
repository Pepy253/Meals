<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Category extends Model implements TranslatableContract
{
    use Translatable;
    
    public $translatedAttributes = ['title'];
    protected $fillable = ['slug', 'created_at', 'updated_at'];
    protected $hidden = ['pivot', 'translations'];

    public function meals()
    {
        return $this->hasMany(Meal::class);
    }
}
