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
     * Prints formatted text with foreground and background colors.
     * ----------------
     * Выводит форматированный текст с цветами переднего плана и фона.
     *
     * @param string $text Text to output
     * @param string $fg   Foreground color (key from self::COLOR)
     * @param string $bg   Background color (key from self::COLOR)
     * @return void
     */
    public function printer(string $text, string $fg = "default", string $bg = "default"): void;

    /**
     * Get the data entered in the console.
     * ----------------
     * Получает данные, введённые в консоли.
     *
     * @return string
     */
    public function reader(): string;

    /**
     * Adds a command to the registry
     * ----------------
     * Добавляет команду в реестр.
     * 
     * @param  string $name
     * @param  array  $command
     * @return void
     */
    public function addCommand(string $name, array $command): void;

    /**
     * Calls command methods
     * ----------------
     * Вызывает методы команды.
     * 
     * @param  array $inputArgs
     * @return void
     */
    public function invoke(array $inputArgs): void;

    /**
     * Retrieves the commands registry
     * ----------------
     * Получает реестр команд.
     * 
     * @return array<string, array>
     */
    public function getRegistry(): array;
}
