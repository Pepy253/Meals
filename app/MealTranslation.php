<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MealTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'description', 'language_id'];
}
