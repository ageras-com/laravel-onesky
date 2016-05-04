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
        $translationsPath = $this->translationsPath() . DIRECTORY_SEPARATOR . $baseLocale;

        $locales = array_diff($locales, [$baseLocale]);

        $files = $this->scanDir($translationsPath);

        $this->downloadTranslations(
            $this->client(),
            $this->project(),
            $locales,
            $files
        );

        $this->info('Translations were downloaded successfully!');
    }

    public function downloadTranslations($client, $project, $locales, $files)
    {
        foreach ((array)$locales as $locale) {
            foreach ((array)$files as $file) {
                $this->downloadTranslation($client, $project, $locale, $file);
            }
        }
    }

    public function downloadTranslation($client, $project, $locale, $file)
    {
        $data = $this->prepareTranslationData($project, $locale, $file);

        $response = $client->translations('export', $data);

        $filePath = $this->translationsPath() . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR . $file;

        return file_put_contents($filePath, $response);
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
