<?php

namespace Rudra\Cli\Command;

use Rudra\Cli\Command\ConsoleFacade as Cli;

class ServeCommand
{
    public function actionIndex(): void
    {
        Cli::printer("🌐 Rudra is running:", "cyan");
        exec('php -S 127.0.0.1:8000 -t public');
    }
}
