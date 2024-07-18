<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeEnumCommand extends Command
{
    public $signature = 'make:enum {Enum Name} {--model=}';

    public $description = 'Make New Enum File';

    public function handle()
    {
        $enum_name = $this->argument('Enum Name');
        $fileName = ucfirst($enum_name) . 'Enum';
        $options = $this->options();
        $model_name = data_get($options, 'model');
        if ($model_name) {
            $model_name = ucfirst($model_name);
            $fileName = $model_name . $fileName;
        }
        $folder_name = 'Enums';
        !is_dir(app_path($folder_name)) && mkdir(app_path($folder_name));
        if (!is_file(app_path("$folder_name/" . $fileName . '.php'))) {
            \File::put(app_path($folder_name) . '/' . $fileName . '.php',
                "<?php

namespace App\\$folder_name;

use App\Traits\EnumOptionsTrait;

enum $fileName: string
{
    use EnumOptionsTrait;
}");
            if ($model_name) {
                $this->addEnumToModel($model_name, $enum_name, $fileName);
            }
            $this->alert("Enum $folder_name\\$fileName Created Successfully");
        } else {
            $this->info("Enum $folder_name\\$fileName already exists");
        }
    }

    public function addEnumToModel($model_name, $enum_name, $enum_file_name): void
    {
        $model_path = app_path('Models/' . $model_name . '.php');
        $model_content = file_get_contents($model_path);
        $column_name = strtolower(preg_replace('/([A-Z])/', '_$1', lcfirst($enum_name)));
        $append_attribute = $column_name . '_text';
        if (strpos($model_content, $append_attribute)) {
            return;
        }
        $attribute_name = lcfirst($enum_name) . 'Text';
        $new_str=$this->addAttributeFunction($attribute_name,$enum_file_name,$column_name,$model_content);

        $this->addUseAttributeAndEnum($enum_file_name, $new_str);

        $this->addPropertyRead($append_attribute, $new_str);

        $this->addAttributeToAppends($append_attribute, $new_str);

        $this->addAttributeToCasts($column_name, $new_str, $enum_file_name);

        file_put_contents($model_path, $new_str);
    }

    private function addAttributeFunction($attribute_name,$enum_file_name,$column_name,$model_content): array|string
    {
        $attribute_function = "
    protected function $attribute_name(): Attribute
    {
        return Attribute::make(
            get: fn(\$value, array \$attributes) => $enum_file_name::getTrans(\$this->$column_name),
        );
    }
";
        return substr_replace($model_content, $attribute_function, -2, 0);
    }
    private function addUseAttributeAndEnum($enum_file_name, &$modelContent): void
    {
        if (!str_contains($modelContent, 'Illuminate\Database\Eloquent\Casts\Attribute')) {
            $modelContent = substr_replace($modelContent, "use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Enums\\$enum_file_name;
", 30, 0);
        }else{
            $modelContent = substr_replace($modelContent, "use App\Enums\\$enum_file_name;
", 30, 0);
        }
    }

    private function addAttributeToAppends($append_attribute, &$new_str): void
    {
        $appends_pattern = '/protected\s+\$appends\s+=\s+\[([^\]]*)\]/s';
        if (preg_match($appends_pattern, $new_str, $matches)) {
            $appendsArray = $matches[1];

            // Modify the appends array by adding the item
            if (!empty($appendsArray)) {
                $modifiedAppendsArray = rtrim($appendsArray, ", \t\n") . ", '$append_attribute'";
            } else {
                $modifiedAppendsArray = "'$append_attribute'";
            }

            // Replace the original appends array with the modified one
            $new_str = str_replace($matches[0], "protected \$appends = [$modifiedAppendsArray]", $new_str);
        } else {
            $fillablePosition = strpos($new_str, 'protected $fillable');
            if ($fillablePosition) {
                $insertionPosition = $fillablePosition;
                $insertion = "\n\n    protected \$appends = ['$append_attribute'];\n\n    ";
                $new_str = substr_replace($new_str, $insertion, $insertionPosition, 0);
            }
        }
    }

    private function addAttributeToCasts($column_name, &$new_str, $enum_file_name): void
    {
// Check if the property already exists in the casts array
        if (strpos($new_str, "'$column_name' =>") !== false) {
            echo 'Property already exists in the casts array.';
            return;
        }

// Find the position of the casts array
        $castsPosition = strpos($new_str, 'protected $casts');
        if ($castsPosition === false) {
            echo 'Casts array not found in the model file.';
            return;
        }

// Insert the new property into the casts array
        $insertionPosition = $castsPosition + strlen("protected \$casts = [\n") - 1;
        $insertion = "\n        '$column_name' => $enum_file_name::class,";
        $new_str = substr_replace($new_str, $insertion, $insertionPosition, 0);
    }

    private function addPropertyRead($append_attribute, &$new_str): void
    {
        $new_str = preg_replace_callback(
            '/\/\*\*(.*?)\*\//s',
            function ($matches) use ($append_attribute) {
                $block = $matches[0];
                $newAnnotation = "* @property-read string \$$append_attribute";
                return str_replace('*/', "$newAnnotation\n */", $block);
            },
            $new_str,
            1
        );
    }

}
