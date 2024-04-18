<?php

namespace Mahmoudmhamed\LaravelHelpers\Commands;

use Illuminate\Console\Command;

class MakeBuilderCommand extends Command
{
    public $signature = 'make:builder {Model Name}';

    public $description = 'Make New Builder For Model';

    public function handle()
    {
        $model_name=ucfirst($this->argument('Model Name'));
        $fileName = $model_name . 'Builder';
        $folder_name = 'Models/Builders';
        $model_path=app_path('Models/'.$model_name.'.php');
        if (!is_file($model_path)) {
            $this->error("Model $model_name not exists");
            return;
        }
        !is_dir(app_path($folder_name)) && mkdir(app_path($folder_name));
        if (!is_file(app_path("$folder_name/" . $fileName . '.php'))) {
            \File::put(app_path($folder_name) . '/' . $fileName . '.php',
                "<?php

namespace App\Models\Builders;

class $fileName extends BaseBuilder
{

}");
            $this->alert("Builder $folder_name/$fileName Created Successfully");
        } else {
            $this->info("Builder $folder_name/$fileName already exists");
        }

        //add builder data to model
        $this->addBuilderToModel($model_path,$fileName);
    }

    public function addBuilderToModel($model_path,$builder_name_without_extension): void
    {
        $model_content=file_get_contents($model_path);
        if (strpos($model_content,$builder_name_without_extension)){
            return;
        }
        $builder_data="
    /**
     * @return $builder_name_without_extension
     */
    public static function query(): $builder_name_without_extension
    {
        return parent::query();
    }

    /**
     * @param \$query
     * @return $builder_name_without_extension
     */
    public function newEloquentBuilder(\$query): $builder_name_without_extension
    {
        return new $builder_name_without_extension(\$query);
    }
";
        $newstr = substr_replace($model_content, $builder_data, -2, 0);
        $newstr = substr_replace($newstr, "
use App\Models\Builders\\$builder_name_without_extension;
", 30, 0);

        file_put_contents($model_path,$newstr);
    }
}
