<?php

namespace App\Traits;

use Illuminate\Support\Collection;

/**
 * used to get select option for enum .
 * @author mahmoud-mhamed <mahmoud1272022@gmail.com>
 */
trait EnumOptionsTrait
{
    public static function getOptionsData(): Collection
    {
        return collect(self::cases())->map(function ($row){
            $item['id'] = $row;
            $item['name'] = self::getTrans($row);
            return $item;
        });
    }

    public static function getOptionsIdNameData(): Collection
    {
        return collect(self::cases())->map(function ($row){
            $item['id'] = $row->value;
            $item['name'] = self::getTrans($row);
            return $item;
        });
    }

    public static function getOptionsPluckData(): array
    {
        $options=self::getOptionsData()->toArray();
        return array_combine(self::values(), array_column($options,'name'));
    }

    public static function getTrans($case=null):?string
    {
        return $case?__('enums.' . class_basename(__CLASS__) . '.' . ($case?->value??$case)):null;
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function array(): array
    {
        return array_combine(self::values(), self::names());
    }

    public static function convertStringToEnum($string):?self
    {
        foreach (self::cases() as $case) {
            if($case->value==$string)
                return $case;
        }
        return null;
    }
}
