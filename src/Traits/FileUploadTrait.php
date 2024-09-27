<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * used to upload file in laravel .
 * @author mahmoud-mhamed <mahmoud1272022@gmail.com>
 */
trait FileUploadTrait
{

//    protected array $fileupload = [];

    protected static function bootFileUploadTrait(): void
    {
        static::saving(function (Model $model) {
            self::uploadFiles($model);
        });

        static::deleting(function (Model $model) {
            self::handleDeleteModel($model);
        });

        static::retrieved(static fn(Model $model) => self::handelRetrievedAttr($model));
    }

    public static function handleDeleteModel(Model $model): void
    {
        foreach (self::getFileUpload() as $key => $value) {
            $config = self::getConfigForFileItem($key, $value, $model);
            $column_name = $config['column_name'];
            if (!data_get($model, $column_name) || !data_get($config, 'allow_in_delete'))
                continue;

            //if model allow soft delete
            if (in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($model))) {
                if ($model->isForceDeleting()) {
                    if (data_get($config, 'delete_on_soft_delete')) {
                        self::deleteFile(data_get($config, 'disk'), $model->getOriginal($column_name));
                    }
                } else {
                    if (data_get($config, 'delete_file_in_normal_delete_when_use_soft_delete')) {
                        self::deleteFile(data_get($config, 'disk'), $model->getOriginal($column_name));
                    }
                }
            } else
                self::deleteFile(data_get($config, 'disk'), $model->getOriginal($column_name));
        }
    }

    public static function handelRetrievedAttr(Model $model)
    {
        foreach (self::getFileUpload() as $key => $value) {
            $config = self::getConfigForFileItem($key, $value, $model);
            if (!data_get($model, $config['column_name'])) {
                if ($config['default_asset']) {
                    if (data_get($config, 'multiple')) {
                        $model->setAttribute($config['column_name'] . '_url', [asset($config['default_asset'])]);
                    } else {
                        $model->setAttribute($config['column_name'] . '_url', asset($config['default_asset']));
                    }
                    return;
                }
                return null;
            }
            if (data_get($config, 'multiple')) {
                $response=[];
                foreach (self::jsonToArray($model->{$config['column_name']}) as $temp) {
                    $response[]=Storage::disk(data_get($config, 'disk'))->url($temp);
                }
                $model->setAttribute($config['column_name'] . '_url', $response);
            } else {
                $model->setAttribute($config['column_name'] . '_url', Storage::disk(data_get($config, 'disk'))->url($model->{$config['column_name']}));
            }
        }
    }

    public static function uploadFiles($model): void
    {
        foreach (self::getFileUpload() as $key => $value) {
            $config = self::getConfigForFileItem($key, $value, $model);
            $column_name = $config['column_name'];
            unset($model->{$column_name . '_url'});
            if (!data_get($config, 'multiple')) {
                if (request()->hasFile($column_name)) {
                    if (data_get($config, 'on_update_delete_old_file') && $model->getOriginal($column_name)) {
                        self::deleteFile(data_get($config, 'disk'), $model->getOriginal($column_name));
                    }
                    $model->{$column_name} = request()->file($column_name)->store(
                        data_get($config, 'path'),
                        options: [
                            'disk' => data_get($config, 'disk'),
                        ]
                    );
                    return;
                }
                if ($config['on_update_not_null']) {
                    $model->{$column_name} = $model->getOriginal($column_name) ?? null;
                    return;
                }
                if (data_get($config, 'on_update_delete_old_file') && $model->getOriginal($column_name)) {
                    self::deleteFile(data_get($config, 'disk'), $model->getOriginal($column_name));
                    return;
                }
            }
            if (data_get($config, 'multiple')) {
                $old_column_value=self::jsonToArray($model->getOriginal($column_name));
                $new_column_value = data_get($model, $column_name);
                if (count($new_column_value)) {
                    $new_files = [];
                    foreach ($new_column_value as $t_key => $item) {
                        if (request()->hasFile($column_name . '.' . $t_key)) {
                            $new_files[] = request()->file($column_name . '.' . $t_key)->store(
                                data_get($config, 'path'),
                                options: [
                                    'disk' => data_get($config, 'disk'),
                                ]
                            );
                        }else{
                            //add string old value to new column value
                            $temp_new_value=data_get($new_column_value,$t_key);
                            if(in_array($temp_new_value,$old_column_value)){
                                $new_files[]=data_get($new_column_value,$t_key);
                                continue;
                            }
                            foreach ($old_column_value as $z_item) {
                                if(str_contains($temp_new_value,$z_item)){
                                    $new_files[]=$z_item;
                                    break;
                                }
                            }
                        }
                    }
                    //delete old_files
                    if (data_get($config, 'on_update_delete_old_file') && count($old_column_value)) {
                        foreach ($old_column_value as $item) {
                            if (!in_array($item,$new_files)) {
                                self::deleteFile(data_get($config, 'disk'), $item);
                            }
                        }
                    }
                    $model->{$column_name} = $new_files;
                    return;
                }

                if ($config['on_update_not_null']) {
                    $model->{$column_name} = $model->getOriginal($column_name) ?? null;
                    return;
                }
                if (data_get($config, 'on_update_delete_old_file') && $model->getOriginal($column_name)) {
                    foreach ($old_column_value as $item)
                        self::deleteFile(data_get($config, 'disk'), $item);
                    return;
                }
            }
        }
    }

    private static function jsonToArray($data)
    {
        if (is_array($data)) return $data;
        return json_decode($data)??[];
    }
    public static function deleteFile($disk, $path): void
    {
        Storage::disk($disk)->delete($path);
    }

    private static function getConfigForFileItem($key, $value, $model): array
    {
        $has_custom_config = !is_int($key);
        $column_name = $has_custom_config ? $key : $value;
        $new_options = $has_custom_config ? $value : [];
        $path = self::getConfig($new_options, 'path') ?? $model->getTable();
        return [
            'has_custom_config' => $has_custom_config,
            'column_name' => $column_name,
            'disk' => self::getConfig($new_options, 'disk'),
            'multiple' => self::getConfig($new_options, 'multiple'),
            'path' => $path,
            'on_update_not_null' => self::getConfig($new_options, 'on_update_not_null'),
            'on_update_delete_old_file' => self::getConfig($new_options, 'on_update_delete_old_file'),
            'auto_delete' => self::getConfig($new_options, 'auto_delete'),
            'default_asset' => self::getConfig($new_options, 'default_asset'),
            'allow_in_delete' => self::getConfig($new_options, 'allow_in_delete'),
            'delete_on_soft_delete' => self::getConfig($new_options, 'delete_on_soft_delete'),
            'delete_file_in_normal_delete_when_use_soft_delete' => self::getConfig($new_options, 'delete_file_in_normal_delete_when_use_soft_delete'),
        ];
    }

    private static function getConfig(null|array $new_option, $config_key)
    {
        if (!$new_option || data_get($new_option, $config_key) === null)
            return config('fileupload.' . $config_key);
        return data_get($new_option, $config_key);
    }

    public static function getFileUpload(): array
    {
        return (new self)->fileupload ?: [];
    }
}
