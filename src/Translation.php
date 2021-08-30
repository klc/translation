<?php

namespace KLC;

use App\Models\Language;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redis;

class Translation
{
    /**
     * @param string $slug
     * @param int $languageId
     * @param array $params
     * @return string
     */
    public static function translate(string $slug, int $languageId, array $params = []): string
    {
        if (!$languageId) {
            $languageCode = App::getLocale();
            $language = Language::where('code', $languageCode)->first();

            if (!$language) {
                $language = Language::where('code', Config::get('app.fallback_locale'))->first();
            }

            $languageId = $language->id;
        }

        $memory = new TranslationFromMemory();
        $cache = new TranslationFromRedis();
        $db = new TranslationFromDb();

        $memory->next($cache)->next($db);
        $translate = $memory->run(['language_id' => $languageId, 'slug' => $slug]);

        return sprintf($translate, ...$params);
    }

    /**
     * @param int $languageId
     */
    public static function cacheClear(int $languageId = 0)
    {
        $client = Redis::connection();
        $client->setName('translation');

        if (!$languageId) {
            $languages = Language::all();

            foreach ($languages as $language) {
                $client->del('translations:' . $language->id);
            }

        } else {
            $client->del('translations:' . $languageId);
        }
    }
}