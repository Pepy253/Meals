<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMealTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meal_translations', function (Blueprint $table) {
            $table->integer('meal_id')->unsigned();
            $table->integer('language_id')->unsigned();
            $table->string('locale')->index();

            $table->string('title');
            $table->text('description');

            $table->primary(['meal_id', 'language_id']);
            $table->unique(['meal_id','language_id']);
            $table->foreign('meal_id')->references('id')->on('meals')->onDelete('cascade');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meal_translations');
    }
}
