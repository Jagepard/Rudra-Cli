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

    public function actionIndex()
    {
        $this->console->printer("Вы готовы дети?  Скажите 'да' капитан: ");

        $line = fgets(fopen("php://stdin","r"));

        if(trim($line) != 'да'){
            $this->console->printer("actionIndex\n");
            exit;
        }

        $this->console->printer("Привет Сквидвард!\n");
    }

    public function actionSecond()
    {
        $this->console->printer("actionSecond!\n");
    }
}
