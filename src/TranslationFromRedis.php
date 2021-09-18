<?php

namespace KLC;

use Illuminate\Redis\Connections\Connection;
use Illuminate\Support\Facades\Redis;

class TranslationFromRedis extends DataChain
{
    /** @var Connection */
    protected static $client;

    public function __construct()
    {
        if (!self::$client) {
            self::$client = Redis::connection();
            self::$client->setName('translation');
        }
    }

    /**
     * @param array $params
     * @return string|false
     */
    protected function handle($params)
    {
        $translation = self::$client->hget('translations:'.$params['language_id'], $params['slug']);

        if (empty($translation)) {
            return false;
        }

        return $translation;
    }

    /**
     * @param array $params
     * @param string $result
     * @return string
     */
    protected function terminate($params, $result)
    {
        self::$client->hset('translations:'.$params['language_id'], $params['slug'], $result);

        return $result;
    }
}