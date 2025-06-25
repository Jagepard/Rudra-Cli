<?php

declare(strict_types = 1);

/**
 * @author  : Jagepard <jagepard@yandex.ru">
 * @license https://mit-license.org/ MIT
 */

namespace Rudra\Cli;

interface ConsoleInterface
{
    /**
     * Prints formatted text
     * 
     * @param  string $text
     * @param  string $fg
     * @param  string $bg
     * @return void
     */
    public function printer(string $text, string $fg = "default", string $bg = "default"): void;

    /**
     * Get the data entered in the console
     * 
     * @return string
     */
    public function reader(): string;

    /**
     * Adds a command to the registry
     * 
     * @param  string $name
     * @param  array $command
     * @return void
     */
    public function addCommand(string $name, array $command): void;

    /**
     * Calls command methods
     *
     * @param  array $inputArgs
     * @return void
     */
    public function invoke(array $inputArgs): void;

    /**
     * Retrieves the commands registry
     *
     * @return array
     */
    public function getRegistry(): array;
}
