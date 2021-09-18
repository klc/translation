<?php

namespace KLC;

class TranslationFromMemory extends DataChain
{
    protected static $translations = [];

    /**
     * @param $params
     * @return false|string
     */
    function handle(array $params)
    {

        if (!isset($translations[$params['language_id']][$params['slug']])) {
            return false;
        }

        return $translations[$params['language_id']][$params['slug']];
    }

    /**
     * @param array $params
     * @param string $result
     * @return string
     */
    function terminate(array $params, $result)
    {
        self::$translations[$params['language_id']][$params['slug']] = $result;

        return $result;
    }
}