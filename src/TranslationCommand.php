<?php

namespace KLC;

use Illuminate\Console\Command;

class TranslationCommand extends Command
{
    /** @var string $signature */
    protected $signature = 'translation:install';

    protected $description = 'installing translation package';

    protected $files = [
        'stubs/models/Language.stub' => 'app/Models/Language.php',
        'stubs/models/Translation.stub' => 'app/Models/Translation.php',
        'stubs/migrations/2021_08_28_074159_create_languages_table.php' => 'database/migrations/2021_08_28_074159_create_languages_table.php',
        'stubs/migrations/2021_08_28_074251_create_translations_table.php' => 'database/migrations/2021_08_28_074251_create_translations_table.php',
    ];

    public function handle()
    {
        if (!is_dir(base_path('app/Models'))) {
            mkdir(base_path('app/Models'), 0755, true);
        }

        if (!is_dir(base_path('database/migrations'))) {
            mkdir(base_path('database/migrations'), 0755, true);
        }

        foreach ($this->files as $from => $to) {
            copy($from, $to);
        }

        $this->info('installation finished');
    }
}