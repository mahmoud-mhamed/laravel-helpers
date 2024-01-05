<?php

namespace Mahmoudmhamed\LaravelHelpers\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CopyEnumsToJs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enums:clone-to-js';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'clone All enums in app enums to js';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = app_path('Enums');
        $enums = [];
        collect(File::allFiles($path))->flatMap(function ($file) use (&$enums) {
            $file_name = $file->getBasename('.php');
            $cases = (new \ReflectionClass("App\Enums\\" . $file_name))->getConstants();
            $enums[$file_name] = collect(array_values($cases))->pluck('value', 'name');
        });

        $data = 'export const Enum = ' . json_encode($enums);
        file_put_contents(resource_path('js/enum.js'), $data);
        $this->info("Success Copy Enum To Js!");
    }
}
