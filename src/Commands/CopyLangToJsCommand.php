<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class CopyLangToJsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lang:copy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'trans lang folder from php to js';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $langs = ['ar'];
        $trans_files=['lang.php','base.php','enums.php','abilities.php'];
        $this->output->progressStart(count($langs));
        foreach($langs as $lang)
        {
            App::setLocale($lang);
            $path = lang_path($lang);
            $collection = collect(File::allFiles($path))->flatMap(function ($file,$lang) use ($trans_files) {
                if (in_array( $file->getBasename(''),$trans_files)){
                    return [
                        ($translation = $file->getBasename('.php')) => trans($translation,array(),null,$lang),
                    ];
                }
            });
            $data='export default '.json_encode($collection->toArray());
            file_put_contents(resource_path('js/Lang').'/'.$lang.'_php.js',
                $data
            );
            $this->output->progressAdvance();
        }
        $this->output->progressFinish();
    }
}
