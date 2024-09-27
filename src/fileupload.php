<?php
return [
    //default config
    'multiple' => false,
    'disk' => env('FILE_UPLOAD_DEFAULT_DISK', 'public'),
    'path' => null,//default path for save files
    'default_asset' => true,//take path for default file in asset
    'on_update_not_null' => true,//true=> ignore null value in update
    'on_update_delete_old_file' => true,//true in update delete old file

    'allow_in_delete' => true,//to allow to delete file in delete model
    'delete_on_soft_delete' => true,//to allow to delete in soft delete
    'delete_file_in_normal_delete_when_use_soft_delete' => true,//to allow to delete normal delete when use soft delete


];
/*protected array $fileupload = [
//        'avatar',
    'avatar'=>[
        'multiple'=>false,
        'disk'=>'public',
        'path'=>'/avatar',
        'on_update_not_null'=>true,
        'on_change_delete_old_file'=>true,
        'auto_delete'=>true,
//            'default_asset'=>null,
        'default_asset'=>"default_image/avatar.png",
    ],
];*/
