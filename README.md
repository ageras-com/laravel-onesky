# Ageras Laravel Onesky

A seamless integration between Laravel and the Onesky API.

By using artisan commands you can easily push new phrases ready for translation, and pull translated phrases ready for production.

### Usage

Add the service provider to the `app.php` file:
```
'providers' => [
    ...
    Ageras\LaravelOneSky\ServiceProvider::class,
]
```

When you are ready to translate your language files use this simple artisan command to upload them to your OneSky account:
```
php artisan onesky:push
```

When your language files have been translated, use this command to download them directly into your project:
```
php artisan onesky:pull
```

If you only want certain languages to be pushed/pulled, you can use the `--lang=` flag:
```
php artisan onesky:push --lang=en,da,no
```