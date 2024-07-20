<?php

namespace Mahmoudmhamed\LaravelHelpers\Traits;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * used to get select option for enum .
 * @author mahmoud-mhamed <mahmoud1272022@gmail.com>
 */
trait UseTranslationsTrait
{
    use HasTranslations;

    protected static function bootUseTranslationsTrait(): void
    {
        static::retrieved(static fn(Model $model) => self::handelAttr($model, 'retrieved'));
        static::saving(static fn(Model $model) => self::handelAttr($model, 'saving'));
    }

    private static function handelAttr(Model $model, string $type): void
    {
        foreach ($model->translatable as $translate) {
            if ($type === 'retrieved') {
                if (self::stringIsJson($model->getAttributes()[$translate]))
                    $model->setAttribute($translate . '_text', nl2br($model->getTranslation($translate, app()->getLocale())));
            } else {
                unset($model->{$translate . '_text'});
            }
        }
    }

    private static function stringIsJson(string $string): bool
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}
