<?php

namespace Mahmoudmhamed\LaravelHelpers\Commands;

use Illuminate\Console\Command;

class MakeEnumCommand extends Command
{
    public $signature = 'make:enum {Enum Name}';

    public $description = 'Make New Enum File';

    public function handle()
    {
        $fileName = ucfirst($this->argument('Enum Name')) . 'Enum';
        $folder_name = 'Enums';
        !is_dir(app_path($folder_name)) && mkdir(app_path($folder_name));
        if (!is_file(app_path("$folder_name/" . $fileName . '.php'))) {
            \File::put(app_path($folder_name) . '/' . $fileName . '.php',
                "<?php

namespace App\\$folder_name;

use Mahmoudmhamed\LaravelHelpers\Traits\EnumOptionsTrait;

enum $fileName: string
{
    use EnumOptionsTrait;
}");
             $this->alert("Enum $folder_name\\$fileName Created Successfully");
        } else {
             $this->info("Enum $fileName already exists");
        }
    }
}
