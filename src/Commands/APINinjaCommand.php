<?php

namespace BataBoom\APINinja\Commands;

use Illuminate\Console\Command;

class APINinjaCommand extends Command
{
    public $signature = 'apininja';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
