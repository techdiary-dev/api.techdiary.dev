<?php

namespace App\Console\Commands;

use App\Events\TestEvent;
use Illuminate\Console\Command;

class testCommand extends Command
{
    protected $signature = 'test';

    protected $description = 'Command description';

    public function handle(): void
    {
        TestEvent::dispatch(
            "Rayhan",
            28
        );
    }
}
