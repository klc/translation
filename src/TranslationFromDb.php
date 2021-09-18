<?php

namespace KLC;

use App\Models\Translation as TranslationModel;

class TranslationFromDb extends DataChain
{

    /**
     * @param array $params
     * @return string
     */
    protected function handle($params): string
    {
        $translation = TranslationModel::where('language_id', $params['language_id'])
            ->where('slug', $params['slug'])
            ->first();

        if (!$translation) {
            return $params['slug'];
        }

        return $translation->translation;
    }
}