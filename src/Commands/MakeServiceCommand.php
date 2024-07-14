<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeServiceCommand extends Command
{
    public $signature = 'make:service {Service Name}';

    public $description = 'Make New Service';

    public function handle()
    {
        $service_name=ucfirst($this->argument('Service Name'));
        $fileName = $service_name . 'Service';
        $folder_name = 'Services';
        !is_dir(app_path($folder_name)) && mkdir(app_path($folder_name));
        if (!is_file(app_path("$folder_name/" . $fileName . '.php'))) {
            \File::put(app_path($folder_name) . '/' . $fileName . '.php',
                "<?php

namespace App\Services;

class $fileName extends BaseService
{

}");
            $this->alert("Service $folder_name/$fileName Created Successfully");
        } else {
            $this->info("Service $folder_name/$fileName already exists");
        }

    }
}
