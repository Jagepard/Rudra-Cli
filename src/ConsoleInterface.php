<?php

/**
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 *
 * @author  Korotkov Danila (Jagepard) <jagepard@yandex.ru>
 * @license https://mozilla.org/MPL/2.0/  MPL-2.0
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
