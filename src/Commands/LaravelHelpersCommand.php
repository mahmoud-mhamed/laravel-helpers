<?php

namespace Mahmoudmhamed\LaravelHelpers\Commands;

use Illuminate\Console\Command;

class LaravelHelpersCommand extends Command
{
    public $signature = 'laravel-helpers';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
