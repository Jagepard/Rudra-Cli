<?php

declare(strict_types = 1);

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @license   https://mit-license.org/ MIT
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
