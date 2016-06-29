# Ageras Laravel Onesky
[![Latest Stable Version](https://poser.pugx.org/ageras/laravel-onesky/v/stable)](https://packagist.org/packages/ageras/laravel-onesky)
[![Total Downloads](https://poser.pugx.org/ageras/laravel-onesky/downloads)](https://packagist.org/packages/ageras/laravel-onesky)
[![Latest Unstable Version](https://poser.pugx.org/ageras/laravel-onesky/v/unstable)](https://packagist.org/packages/ageras/laravel-onesky)
[![Monthly Downloads](https://poser.pugx.org/ageras/laravel-onesky/d/monthly)](https://packagist.org/packages/ageras/laravel-onesky)

## Description
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

Next, add `ONESKY_API_KEY` and `ONESKY_SECRET` to your `.env` file.

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

## Contributing

### Bug Reports
All issues are welcome, to create a better product, but your issue should contain a title and a clear description of the issue. You should also include as much relevant information as possible and a code sample that demonstrates the issue.

### Which Branch?
All bug fixes should be sent to the develop branch. Bug fixes should never be sent to the master

### Security Vulnerabilities
If you discover a security vulnerability within Sherlock package, write an email to Ageras' development team.

### Coding Style
Ageras' follows the PSR-2 coding standard and the [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md) autoloading standard.

### StyleCI
 StyleCI automatically fixes code style to match the standard.

## License

    Copyright 2016 Ageras Aps

    Licensed under the Apache License, Version 2.0 (the "License");
    you may not use this file except in compliance with the License.
    You may obtain a copy of the License at

       http://www.apache.org/licenses/LICENSE-2.0

    Unless required by applicable law or agreed to in writing, software
    distributed under the License is distributed on an "AS IS" BASIS,
    WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
    See the License for the specific language governing permissions and
    limitations under the License.

