<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Language;
use App\Models\Translation;

class CreateTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->integer('language_id');
            $table->string('slug');
            $table->string('translation');
            $table->timestamps();

            $table->unique(['language_id', 'slug']);
        });

        $languages = Language::all()->keyBy('code');

        Translation::insert([
            [
                'language_id' => $languages['TR']->id,
                'slug' => 'hello_world',
                'translation' => 'Merhaba Dünya'
            ], [
                'language_id' => $languages['EN']->id,
                'slug' => 'hello_world',
                'translation' => 'Hello World'
            ], [
                'language_id' => $languages['DE']->id,
                'slug' => 'hello_world',
                'translation' => 'Hallo Welt '
            ], [
                'language_id' => $languages['TR']->id,
                'slug' => 'hello',
                'translation' => 'Merhaba %s'
            ], [
                'language_id' => $languages['EN']->id,
                'slug' => 'hello',
                'translation' => 'Hello %s'
            ], [
                'language_id' => $languages['DE']->id,
                'slug' => 'hello',
                'translation' => 'Hallo %s'
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('translations');
    }
}
