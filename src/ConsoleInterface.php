<?php

declare(strict_types = 1);

/**
 * @author  : Jagepard <jagepard@yandex.ru">
 * @license https://mit-license.org/ MIT
 */

namespace Rudra\Cli;

interface ConsoleInterface
{
    public function printer(string $text, string $fg = "default", string $bg = "default"): void;
    // public function reader(): string;
    public function addCommand($name, $command): void;
    public function invoke($inputArgs): void;
    public function getRegistry(): array;
}
