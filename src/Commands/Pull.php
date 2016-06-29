<?php

namespace Ageras\LaravelOneSky\Commands;

class Pull extends BaseCommand
{
    protected $signature = 'onesky:pull {--lang=} {--project=}';

    protected $description = 'Pull the language files from OneSky';

    public function handle()
    {
        $baseLocale = $this->baseLocale();
        $locales = $this->locales();
        $translationsPath = $this->translationsPath().DIRECTORY_SEPARATOR.$baseLocale;

        $locales = array_diff($locales, [$baseLocale]);

        $files = $this->scanDir($translationsPath);

        $this->downloadTranslations(
            $this->client(),
            $this->project(),
            $locales,
            $files
        );

        switch ($this->result) {
            case static::SUCCESS:
                $this->info('Translations were downloaded successfully!');
                break;
            case static::UNKNOWN_ERROR:
                $this->error('Something unexpected happened during the translation download. Please check the console output.');
        }
    }

    public function downloadTranslations($client, $project, $locales, $files)
    {
        foreach ((array) $locales as $locale) {
            foreach ((array) $files as $file) {
                $this->downloadTranslation($client, $project, $locale, $file);
            }
        }
    }

    public function downloadTranslation($client, $project, $locale, $file)
    {
        $data = $this->prepareTranslationData($project, $locale, $file);

        $response = $client->translations('export', $data);

        if (!is_null(json_decode($response))) {
            $this->result = static::UNKNOWN_ERROR;
            $this->invalidResponse($locale, $file, $response);

            return false;
        }

        $filePath = $this->translationsPath().DIRECTORY_SEPARATOR.$locale.DIRECTORY_SEPARATOR.$file;

        return file_put_contents($filePath, $response);
    }

    public function invalidResponse($locale, $file, $response)
    {
        $this->error('Invalid response:');
        $this->error("  File:       {$file}");
        $this->error("  Locale:     {$locale}");
        $this->error("  Response:   {$response}");
    }

    public function prepareTranslationData($project, $locale, $file)
    {
        return [
            'project_id'       => $project,
            'locale'           => $locale,
            'source_file_name' => $file,
        ];
    }
}
