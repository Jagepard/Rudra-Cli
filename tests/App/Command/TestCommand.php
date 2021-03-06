<?php


namespace Rudra\Cli\Tests\App\Command;

use Rudra\Cli\ConsoleFacade as Cli;

class TestCommand
{
    public function actionIndex()
    {
        Cli::printer("Вы готовы дети?  Скажите ", "magneta");
        Cli::printer("ДА", "yellow");
        Cli::printer(" капитан: ", "magneta");

        if(trim(Cli::read()) != 'да'){
            Cli::printer("Неверный ответ(\n", "red");
            exit;
        }

        Cli::printer("Привет Сквидвард!\n", "green");
    }

    public function actionSecond()
    {
        Cli::printer("actionSecond!\n");
    }
}
