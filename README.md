# Ageras Laravel Onesky
[![Latest Stable Version](https://poser.pugx.org/ageras/laravel-onesky/v/stable)](https://packagist.org/packages/ageras/laravel-onesky)
[![Total Downloads](https://poser.pugx.org/ageras/laravel-onesky/downloads)](https://packagist.org/packages/ageras/laravel-onesky)
[![Latest Unstable Version](https://poser.pugx.org/ageras/laravel-onesky/v/unstable)](https://packagist.org/packages/ageras/laravel-onesky)
[![License](https://poser.pugx.org/ageras/laravel-onesky/license)](https://packagist.org/packages/ageras/laravel-onesky)
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

    Copyright (c) 2016: Ageras Aps and other contributors:

    Permission is hereby granted, free of charge, to any person 
    obtaining a copy of this software and associated documentation 
    files (the "Software"), to deal in the Software without restriction, 
    including without limitation the rights to use, copy, modify, merge,
     publish, distribute, sublicense, and/or sell copies of the Software, 
     and to permit persons to whom the Software is furnished to do so, 
     subject to the following conditions:

    The above copyright notice and this permission notice shall be included 
    in all copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS 
    OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL 
    THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR 
    OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, 
    ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR 
    OTHER DEALINGS IN THE SOFTWARE.
