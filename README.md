# This is my package laravel-helpers

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mahmoud-mhamed/laravel-helpers.svg?style=flat-square)](https://packagist.org/packages/mahmoud-mhamed/laravel-helpers)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/mahmoud-mhamed/laravel-helpers/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/mahmoud-mhamed/laravel-helpers/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/mahmoud-mhamed/laravel-helpers/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/mahmoud-mhamed/laravel-helpers/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mahmoud-mhamed/laravel-helpers.svg?style=flat-square)](https://packagist.org/packages/mahmoud-mhamed/laravel-helpers)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us


We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

install the package via composer:

```bash
composer require mahmoud-mhamed/laravel-helpers
```
## Before Use Any Command
##### must add \Mahmoudmhamed\LaravelHelpers\Providers\PackageServiceProvider::class to config=>app->providers array
#### to force publish any file add --force to command

publish command create builder:

```bash
php artisan vendor:publish --tag="command-create-builder" 
```
#### Example
```bash
php artisan make:builder ModelName 
```

publish command make New Enum File:

```bash
php artisan vendor:publish --tag="command-create-enum" 
```
#### Example

```bash
php artisan make:enum FileName
```

publish base model File:

```bash
php artisan vendor:publish --tag="base-model" 
```
publish base date text trait:

```bash
php artisan vendor:publish --tag="date-text-trait" 
```


Publish Command To Clone Enums From app => Enums To resources => js => enum.js:

```bash
php artisan vendor:publish --tag="clone-enums-to-js-command"
```

### You Can Run Command From package.json by add to scripts
```
{
    ....
    "scripts": {
        "lang": "php artisan lang:run && php artisan ability:run",
        "lang-run": "php artisan lang:run",
        "ability-run": "php artisan ability:run",
        "dev": "vite",
        "build": "vite build"
    },
    ...
}
```


### To allow auto generate file if use vite.config.js in plugins array add
```
    plugins: [
    ....
    {
        name: "enum_clone",
        enforce: "post",
        handleHotUpdate({ server, file }) {
            if (file.includes("/app/Enums")) {
                exec(
                    "php artisan enums:clone-to-js",
                    (error, stdout) =>
                        error === null &&
                        console.log(`Enum Js File Generated Successfully !`)
                );
            }
        },
    },
],

```


## Credits

- [mahmoud-mhamed](https://github.com/mahmoud-mhamed)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
