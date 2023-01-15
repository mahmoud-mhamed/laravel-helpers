<?php

namespace Mahmoudmhamed\LaravelHelpers\Traits;

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
            $item['name'] = __(config('helpers.enum_options_trait.trans_file_name').'.' . class_basename(__CLASS__) . '.' . $row->value);
            return $item;
        });
    }
}
