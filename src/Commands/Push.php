<?php

namespace Ageras\LaravelOneSky\Commands;

use Ageras\LaravelOneSky\Exceptions\NumberExpected;
use Illuminate\Console\Command;
use Onesky\Api\Client;
use Onesky\Api\FileFormat;

class Push extends Command
{
    protected $signature = 'onesky:push {--lang=} {--project=}';

    protected $description = 'Push the language files to OneSky';

    public function handle()
    {
        $locale = $this->baseLocale();
        $translationsPath = $this->translationsPath() . DIRECTORY_SEPARATOR . $locale;

        $files = $this->scanDir($translationsPath);

        $files = array_map(function($fileName) use (&$locale, &$translationsPath) {
            return $translationsPath . DIRECTORY_SEPARATOR . $fileName;
        }, $files);

        $response = $this->uploadFiles(
            $this->client(),
            $this->project(),
            $locale,
            $files
        );

    }

    public function baseLocale()
    {
        return $this->config()['onesky']['base_locale'];
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
        return $this->laravel->config['onesky'];
    }

    public function project()
    {
        $config = $this->config();
        $project = $this->option('project');

        if(!$project && isset($config['default_project_id'])) {
            $project = $config['default_project_id'];
        }

        if($project && (string)(int)$project === (string)$project) {
            return $project;
        }

        throw new NumberExpected('--project');
    }

    /**
     * @param \OneSky\Api\Client $client
     * @param $project
     * @param $locale
     * @param $filePath
     * @param array $files
     */
    public function uploadFiles($client, $project, $locale, $filePath, array $files)
    {
        $data = $this->prepareUploadData($project, $locale, $filePath, $files);

        $client->files('upload', $data);
    }

    public function prepareUploadData($project, $locale, $filePath, array $files)
    {
        $data = [];
        foreach($files as $file) {
            $data[] = [
                'project_id' => $project,
                'file' => $filePath . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR . $file,
                'file_format' => FileFormat::PHP,
                'locale' => $locale,
            ];
        }

        return $data;
    }

    public function scanDir($dir, $directoriesOnly = false)
    {
        $fileNames = array_values(array_diff(scandir($dir), ['..', '.']));

        if(!$directoriesOnly) {
            return $fileNames;
        }

        return array_filter($fileNames, function($fileName) use (&$dir) {
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
