<?php

namespace Ageras\LaravelOneSky\Commands;

use Ageras\LaravelOneSky\Exceptions\NumberExpected;
use Illuminate\Console\Command;

class Push extends Command
{
    protected $signature = 'onesky:push {--lang=} {--project=}';

    protected $description = 'Push the language files to OneSky';

    public function handle()
    {
        $this->uploadFiles();
    }

    public function languages()
    {
        $languageString = $this->option('lang');
        if($languageString && $languages = explode(',', $languageString)) {
            return $languages;
        }
        $translationsPath = $this->translationsPath();

        return $this->scanDir($translationsPath);
    }

    public function translationsPath()
    {
        $config = $this->config();
        $basePath = $this->laravel->basePath();

        if(isset($config['translations_path'])) {
            return $basePath . DIRECTORY_SEPARATOR . $config['translations_path'];
        }

        return resource_path('lang');
    }

    public function config()
    {
        $this->laravel->config['onesky'];
    }

    public function project()
    {
        $config = $this->config();
        $project = $this->option('project');

        if(!$project && isset($config['project'])) {
            $project = $config['project'];
        }

        if($project && (string)(int)$project === (string)$project) {
            return $project;
        }

        throw new NumberExpected();
    }

    public function uploadFiles()
    {
        $client = $this->client();
        $project = $this->project();

        foreach($this->languages() as $language) {
            //
        }
    }

    public function scanDir($dir, $directoriesOnly = false)
    {
        $fileNames = array_diff(scandir($dir), ['..', '.']);

        if(!$directoriesOnly) {
            return $fileNames;
        }

        return array_filter($fileNames, function($fileName) use (&$translationsPath) {
            return is_dir($translationsPath . DIRECTORY_SEPARATOR . $fileName);
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
