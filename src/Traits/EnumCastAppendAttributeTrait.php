<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * used to get select option for enum .
 * @author mahmoud-mhamed <mahmoud1272022@gmail.com>
 */
trait EnumCastAppendAttributeTrait
{
    protected static function bootEnumCastAppendAttributeTrait(): void
    {
        static::retrieved(static fn(Model $model) => self::handelAttr($model, 'retrieved'));
        static::saving(static fn(Model $model) => self::handelAttr($model, 'saving'));
    }

    private static function handelAttr(Model $model, string $type): void
    {
        foreach ($model->getCasts() as $column_name => $enum) {
            if (self::isEnum($enum)) {
                if ($type === 'retrieved') {
                    $model->setAttribute($column_name . '_text', $enum::getTrans($model->$column_name));
                } else {
                    unset($model->{$column_name . '_text'});
                }
            }
        }
    }

    private static function isEnum(string $string_enum_class): bool
    {
        return (boolean)Str::of($string_enum_class)->startsWith('App\Enums') && class_exists($string_enum_class);
    }
}
