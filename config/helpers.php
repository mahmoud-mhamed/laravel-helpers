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
   | nullValue : return value if date is null
   | viewInDiffForHumanIfLessThanOrEqual : convert value to diff for human if value less than or equal 24 H ,null if don't convert to diff for human
   | formatIfDiffInDayGreaterThan : date format if diff in day grater than 7 , null => use default format
   |
   */
    'ModelTrait' => [
        'format' => 'Y-m-d h:i A',
        'nullValue' => '- - - -',
        'viewInDiffForHumanIfLessThanOrEqual' => 24,
        'formatIfDiffInDayGreaterThan' => [
            'value' => 7,
            'format' => 'Y-m-d',
        ],
    ],
];
