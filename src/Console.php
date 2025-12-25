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

use Rudra\Exceptions\LogicException;

class Console implements ConsoleInterface
{
    /*
     * Colors of text decoration in the console
     */
    const COLOR = [
        "default"       => 39,
        "black"         => 30,
        "red"           => 31,
        "green"         => 32,
        "yellow"        => 33,
        "blue"          => 34,
        "magneta"       => 35,
        "cyan"          => 36,
        "light_gray"    => 37,
        "dark_gray"     => 90,
        "light_red"     => 91,
        "light_green"   => 92,
        "light_yellow"  => 93,
        "light_blue"    => 94,
        "light_magneta" => 95,
        "light_cyan"    => 96,
        "white"         => 97,
    ];

    private array $registry = [];
    private $stdin;

    /**
     * @param  $stream
     * @return void
     */
    public function setStdin($stream)
    {
        $this->stdin = $stream;
    }

    /**
     * Prints formatted text
     * 
     * @param string $text
     * @param string $fg
     * @param string $bg
     */
    public function printer(string $text, string $fg = "default", string $bg = "default"): void
    {
        $this->checkColorExists($fg);
        $this->checkColorExists($bg);

        printf("\e[%s;%sm{$text}\e[0m", self::COLOR[$fg], self::COLOR[$bg] + 10);
    }

    /**
     * Get the data entered in the console
     * 
     * @return false|string
     */
    public function reader(): string
    {
        return fgets($this->stdin ?? fopen("php://stdin", "r"));
    }

    /**
     * Adds a command to the registry
     * 
     * @param $name
     * @param $command
     */
    public function addCommand(string $name, array $command): void
    {
        if (array_key_exists($name, $this->registry)) {
            throw new LogicException("Command $name already exist");
        }

        $this->registry[$name] = $command;
    }

    /**
     * Calls command methods
     * 
     * @param $inputArgs
     */
    public function invoke(array $inputArgs): void
    {
        $firstKey = array_key_first($inputArgs);

        if (array_key_exists($firstKey, $this->registry)) {
            $class  = new $this->registry[$firstKey][0];
            $method = $this->registry[$firstKey][1] ?? "actionIndex";

            $class->$method();
        } else {
            $this->printer("⚠️  Command \"$firstKey\" not found" . PHP_EOL, 'light_yellow');
        }
    }

    /**
     * Retrieves the commands registry
     * 
     * @return array
     */
    public function getRegistry(): array
    {
        return $this->registry;
    }

    /**
     * Checks if there is a color in the array
     * 
     * @param string $key
     */
    private function checkColorExists(string $key): void
    {
        if (!array_key_exists($key, self::COLOR)) {
            throw new LogicException("Color $key doesn't exist");
        }
    }
}
