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
    public function printer(string $text, string $fg = "default", string $bg = "default"): void;
    public function reader(): string;
    public function addCommand(string $name, array $command): void;
    public function invoke(array $inputArgs): void;
    public function getRegistry(): array;
}
