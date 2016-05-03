<?php

namespace Ageras\LaravelOneSky\Commands;

use Ageras\LaravelOneSky\Exceptions\NumberExpected;
use Ageras\LaravelOneSky\Exceptions\UnexpectedErrorWhileUploading;
use Illuminate\Console\Command;

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

        $this->uploadFiles(
            $this->client(),
            $this->project(),
            $locale,
            $files
        );

        $this->info('Files were uploaded successfully!');
    }

    public function baseLocale()
    {
        return $this->config()['base_locale'];
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

        if(isset($config['translations_path'])) {
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
     * @param array $files
     */
    public function uploadFiles($client, $project, $locale, array $files)
    {
        $data = $this->prepareUploadData($project, $locale, $files);

        foreach($data as $d) {
            $client->files('upload', $d);
        }
    }

    public function uploadFile($client, $data)
    {
        $jsonResponse = $client->files('upload', $data);
        $jsonData = json_decode($jsonResponse, true);
        $responseStatus = $jsonData['meta']['status'];

        if($responseStatus !== 201) {
            throw new UnexpectedErrorWhileUploading(
                'Upload response status: ' . $responseStatus
            );
        }
    }

    public function prepareUploadData($project, $locale, array $files)
    {
        $data = [];
        foreach($files as $file) {
            $data[] = [
                'project_id' => $project,
                'file' => $file,
                'file_format' => 'PHP_SHORT_ARRAY',
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
