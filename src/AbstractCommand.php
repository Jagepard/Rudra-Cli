<?php

declare(strict_types=1);

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @license   https://mit-license.org/ MIT
 */

namespace Rudra\Cli;

class AbstractCommand
{
    public Console $console;

    public function __construct()
    {
        $this->console = new Console();
    }
}
