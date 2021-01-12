<?php


namespace Rudra\Cli\Tests\App\Command;

use Rudra\Cli\ConsoleFacade as Cli;

class TestCommand
{
    public function actionIndex()
    {
        Cli::printer("Вы готовы дети?  Скажите 'да' капитан: ");

        $line = fgets(fopen("php://stdin","r"));

        if(trim($line) != 'да'){
            Cli::printer("actionIndex\n");
            exit;
        }

        Cli::printer("Привет Сквидвард!\n");
    }

    public function actionSecond()
    {
        Cli::printer("actionSecond!\n");
    }
}
