# This is my package laravel-helpers

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mahmoud-mhamed/laravel-helpers.svg?style=flat-square)](https://packagist.org/packages/mahmoud-mhamed/laravel-helpers)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/mahmoud-mhamed/laravel-helpers/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/mahmoud-mhamed/laravel-helpers/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/mahmoud-mhamed/laravel-helpers/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/mahmoud-mhamed/laravel-helpers/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mahmoud-mhamed/laravel-helpers.svg?style=flat-square)](https://packagist.org/packages/mahmoud-mhamed/laravel-helpers)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us


We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require mahmoud-mhamed/laravel-helpers
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="helpers-config"

#for replace old config if exist
php artisan vendor:publish --tag="helpers-config" --force 

```

You can publish command create builder:

```bash
php artisan vendor:publish --tag="command-create-builder"
```
## Before Use Any Command
##### must add \Mahmoudmhamed\LaravelHelpers\Providers\PackageServiceProvider::class to config=>app->providers array

Command To Make New Enum File:

```bash
php artisan make:enum FileName
```

This is the contents of the published config file:

```php
return [
    /*
   |--------------------------------------------------------------------------
   | Model Trait Defaults
   |--------------------------------------------------------------------------
   |
   | This option controls model trait
   | format : Y-m-d h:i A | Y-m-d or any carbon format
   | null_value : return value if date is null
   | format_diff_for_human_when_less_than_or_equal_hour : convert value to diff for human if value less than or equal 24 H ,null if don't convert to diff for human
   | format_diff_in_day_grater_than : date format if diff in day grater than 7 , null => use default format
   |
   */
    'model_date_trait' => [
        'format' => 'Y-m-d h:i A',
        'null_value' => '- - - -',
        'format_diff_for_human_when_less_than_or_equal_hour' => 24,
        'format_diff_in_day_grater_than' => [
            'value' => 7,
            'format' => 'Y-m-d',
        ],
    ],

    /*
   |--------------------------------------------------------------------------
   | EnumOptionsTrait
   |--------------------------------------------------------------------------
   |
   | trans_file_name : store trans file name
   */
    'enum_options_trait' => [
        'trans_file_name' => 'enums',
    ],

    /*
   |--------------------------------------------------------------------------
   | Localization setting
   |--------------------------------------------------------------------------
   |
   | local : all available local
   | default : default value for local
   | api-header-key : api-header-key for set local
   */
    'localization' => [
        'local' => ['ar', 'en'],
        'default' => 'ar',
        'api-header-key' => 'Content-Language',
    ],
];

```

Command To Make BaseModel File:

```bash
php artisan make:base-model
```

Command To Make BaseBuilder File:

```bash
php artisan make:base-builder
```

Command To Make Builder For Model:

```bash
php artisan make:builder ModelName
```

## Credits

- [mahmoud-mhamed](https://github.com/mahmoud-mhamed)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
