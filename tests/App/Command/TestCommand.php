<?php


namespace Rudra\Cli\Tests\App\Command;

use Rudra\Cli\Console;

class TestCommand
{
    public Console $console;

    public function __construct()
    {
        $this->console = new Console();
    }

    public function actionIndex(...$param)
    {
        echo "Вы готовы дети?  Скажите 'да' капитан: ";

        $handle = fopen ("php://stdin","r");
        $line = fgets($handle);

        if(trim($line) != 'да'){
            echo "ABORTING!\n";
            exit;
        }

        echo "\n";

        $this->console->printer("Привет Сквидвард!");
    }
}
