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
        Cli::printer("Are you ready, kids? ", "magenta");
        Cli::printer("Say AYE", "yellow");
        Cli::printer(" captain: ", "magenta");

    if (strtolower(trim(Cli::reader())) !== 'aye') {
        Cli::printer("I can't hear you!!!\n", "red");
        exit;
    }

        Cli::printer("Who lives in a pineapple under the sea?! SPONGEBOB SQUAREPANTS!!!\n", "green");
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
