<?php declare(strict_types = 1);

/**
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 *
 * @author  Korotkov Danila (Jagepard) <jagepard@yandex.ru>
 * @license https://mozilla.org/MPL/2.0/  MPL-2.0
 */

namespace Rudra\Cli\Tests\App\Command;

use Rudra\Cli\ConsoleFacade as Cli;

class TestCommand
{
    public function actionIndex()
    {
        Cli::printer("Вы готовы дети?  Скажите ", "magneta");
        Cli::printer("ДА", "yellow");
        Cli::printer(" капитан: ", "magneta");

        if(trim(Cli::reader()) != 'ДА'){
            Cli::printer("Не слышу!!!(\n", "red");
            exit;
        }

        Cli::printer("Кто обетает на дне океана?! SPONGEBOB SQUAREPANTS!!!\n", "green");
    }

    public function actionSecond()
    {
        Cli::printer("actionSecond!\n");
    }

    public function customAction()
    {
        Cli::printer("Custom action called!\n");
    }
}
