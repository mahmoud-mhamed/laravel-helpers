<?php

namespace Mahmoudmhamed\LaravelHelpers\Commands;

use Illuminate\Console\Command;

class MakeBaseModelCommand extends Command
{
    public $signature = 'make:base-model';

    public $description = 'Make base model File';

    public function handle()
    {
        $fileName = 'BaseModel';
        $folder_name = 'Models';
        !is_dir(app_path($folder_name)) && mkdir(app_path($folder_name));
        if (!is_file(app_path("$folder_name/" . $fileName . '.php'))) {
            \File::put(app_path($folder_name) . '/' . $fileName . '.php',
                "<?php

namespace App\\$folder_name;

use Illuminate\Database\Eloquent\Model;

class $fileName extends Model
{

}");
             $this->alert("Base Model $folder_name\\$fileName Created Successfully");
        } else {
             $this->info("Base Model $folder_name\\$fileName already exists");
        }
    }
}
