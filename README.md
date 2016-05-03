# Ageras Laravel Onesky

A seamless integration between Laravel and the Onesky API.

By using artisan commands you can easily push new phrases ready for translation and pull translated phrases ready for production.

## Installation

Require this package using composer:
```
composer require ageras/laravel-onesky
```

## Usage

Add the service provider to the `app.php` file:
```
'providers' => [
    ...
    Ageras\LaravelOneSky\ServiceProvider::class,
]
```

Copy the package config to your local config with the publish command:
```
php artisan vendor:publish --provider="Ageras\LaravelOneSky\ServiceProvider"
```

Change the newly published `onesky.php` file so that it matches your project.

When you are ready to translate your language files, use this simple artisan command to upload them to your OneSky account:
```
php artisan onesky:push
```

When your language files have been translated, use this command to download them directly into your project:
```
php artisan onesky:pull
```

If you only want certain languages to be pulled, you can use the `--lang=` flag:
```
php artisan onesky:pull --lang=en,da,no
```

If you have multiple projects, you can use the `--project=` flag to specify the id:
```
php artisan onesky:push --project=1337
```
