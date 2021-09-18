<?php

use Orchestra\Testbench\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Language;
use App\Models\Translation;

class TranslationTest extends TestCase
{
    use RefreshDatabase;

    protected $languages = [
        [
            'name' => 'Türkçe',
            'code' => 'TR'
        ], [
            'name' => 'English',
            'code' => 'EN'
        ], [
            'name' => 'Deutsch',
            'code' => 'DE'
        ]
    ];

    protected function defineDatabaseMigrations()
    {
        $this->loadLaravelMigrations();
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->artisan('migrate')->run();

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('migrate:rollback')->run();
        });
    }

    protected function clearRedisCache($languages)
    {
        foreach ($languages as $language) {
            \KLC\Translation::cacheClear($language->id);
        }
    }

    /**
     * @test
     */
    public function static_translation_test()
    {
        $languages = Language::insert($this->languages);
        $this->assertTrue($languages);

        $languages = Language::all()->keyBy('code');
        $this->assertNotEmpty($languages);

        $translations = Translation::insert([
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
                'translation' => 'Hallo Welt'
            ]
        ]);
        $this->assertTrue($translations);

        $this->clearRedisCache($languages);
        $this->assertEquals('Hello World', \KLC\Translation::translate('hello_world', $languages['EN']->id));
        $this->assertEquals('Merhaba Dünya', \KLC\Translation::translate('hello_world', $languages['TR']->id));
        $this->assertEquals('Hallo Welt', \KLC\Translation::translate('hello_world', $languages['DE']->id));
        $this->clearRedisCache($languages);
    }

    /**
     * @test
     */
    public function dynamic_translation_test()
    {
        $languages = Language::insert($this->languages);
        $this->assertTrue($languages);

        $languages = Language::all()->keyBy('code');
        $this->assertNotEmpty($languages);

        $translations = Translation::insert([
            [
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
        $this->assertTrue($translations);

        $this->clearRedisCache($languages);
        $this->assertEquals('Hello Foo', \KLC\Translation::translate('hello', $languages['EN']->id, ['Foo']));
        $this->assertEquals('Merhaba Foo', \KLC\Translation::translate('hello', $languages['TR']->id, ['Foo']));
        $this->assertEquals('Hallo Foo', \KLC\Translation::translate('hello', $languages['DE']->id, ['Foo']));
        $this->clearRedisCache($languages);
    }
}