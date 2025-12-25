<?php

declare(strict_types = 1);

/**
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 *
 * @author  Korotkov Danila (Jagepard) <jagepard@yandex.ru>
 * @license https://mozilla.org/MPL/2.0/  MPL-2.0
 */

namespace Rudra\Cli;

use Rudra\Container\Traits\FacadeTrait;

/**
 * @method static void   printer(string $text, string $fg = "default", string $bg = "default")
 * @method static string reader()
 * @method static void   addCommand($name, $command)
 * @method static void   invoke($inputArgs)
 * @method static array  getRegistry()
 *
 * @see Router
 */
class ConsoleFacade
{
    use FacadeTrait;
}
