<?php

namespace Ageras\LaravelOneSky\Commands;

use Ageras\LaravelOneSky\Exceptions\NumberExpected;
use Illuminate\Console\Command;

class BaseCommand extends Command
{
    protected $result = 0;

    const SUCCESS = 0;
    const UNKNOWN_ERROR = 1;

    public function baseLocale()
    {
        return $this->config()['base_locale'];
    }

    public function locales()
    {
        $localeString = $this->option('lang');
        if ($localeString && $locales = explode(',', $localeString)) {
            return $locales;
        }
        $translationsPath = $this->translationsPath();

        return $this->scanDir($translationsPath, true);
    }

    public function translationsPath()
    {
        $config = $this->config();

        if (isset($config['translations_path'])) {
            return $config['translations_path'];
        }

        return resource_path('lang');
    }

    public function config()
    {
        return $this->laravel->config['onesky'];
    }

    public function project()
    {
        $config = $this->config();
        $project = $this->option('project');

        if (! $project && isset($config['default_project_id'])) {
            $project = $config['default_project_id'];
        }

        if ($project && (string) (int) $project === (string) $project) {
            return $project;
        }

        throw new NumberExpected('--project');
    }

    public function scanDir($dir, $directoriesOnly = false)
    {
        $fileNames = array_values(array_diff(scandir($dir), ['..', '.']));

        if (! $directoriesOnly) {
            return $fileNames;
        }

        return array_filter($fileNames, function ($fileName) use (&$dir) {
            return is_dir($dir . DIRECTORY_SEPARATOR . $fileName);
        });
    }

    /**
     * @return \OneSky\Api\Client
     */
    public function client()
    {
        return $this->laravel->make('onesky');
    }
}
