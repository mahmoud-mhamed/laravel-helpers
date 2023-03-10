<?php

// config for Mahmoudmhamed/LaravelHelpers
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

    /*
  |--------------------------------------------------------------------------
  | ResponseJson setting
  |--------------------------------------------------------------------------
  |
  | default-use-response-key : return response in array key response
  */
    'ResponseJson' => [
        'default-use-response-key' => true,
    ],
];
