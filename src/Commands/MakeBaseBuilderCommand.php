<?php

namespace Mahmoudmhamed\LaravelHelpers\Commands;

use Illuminate\Console\Command;

class MakeBaseBuilderCommand extends Command
{
    public $signature = 'make:base-builder';

    public $description = 'Make base builder File';

    public function handle()
    {
        $fileName = 'BaseBuilder';
        $folder_name = 'Models/Builders';
        !is_dir(app_path($folder_name)) && mkdir(app_path($folder_name));
        if (!is_file(app_path("$folder_name/" . $fileName . '.php'))) {
            \File::put(app_path($folder_name) . '/' . $fileName . '.php',
                "<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class $fileName extends Builder
{

}");
             $this->alert("Base Builder $folder_name\\$fileName Created Successfully");
        } else {
             $this->info("Base Builder $folder_name\\$fileName already exists");
        }
    }
}
