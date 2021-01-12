<?php

declare(strict_types=1);

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @license   https://mit-license.org/ MIT
 */

namespace Rudra\Cli;

class Console
{
    const COLOR = [
        "default" => 39,
        "black" => 30,
        "red" => 31,
        "green" => 32,
        "yellow" => 33,
        "blue" => 34,
        "magneta" => 35,
        "cyan" => 36,
        "light_gray" => 37,
        "dark_gray" => 90,
        "light_red" => 91,
        "light_green" => 92,
        "light_yellow" => 93,
        "light_blue" => 94,
        "light_magneta" => 95,
        "light_cyan" => 96,
        "white" => 97,
    ];

    private array $registry = [];

    public function printer(string $text, string $fg = "default", string $bg = "default"): void
    {
        $this->checkKey($fg);
        $this->checkKey($bg);

        $fg = self::COLOR[$fg];
        $bg = self::COLOR[$bg] + 10;

        echo "\e[{$fg};{$bg}m{$text}\e[0m\n";
    }

    public function addCommand($name, $command)
    {
        if (array_key_exists($name, $this->registry)) {
            throw new \InvalidArgumentException("Key already exist");
        }

        $this->registry[$name] = $command;
    }

    public function run($inputArgs)
    {
        $firstKey = array_key_first($inputArgs);

        if (array_key_exists($firstKey, $this->registry)) {

            $class = new $this->registry[$firstKey][0];
            $method = $this->registry[$firstKey][1] ?? "actionIndex";

            $class->$method();
        }
    }

    public function checkKey(string $key): void
    {
        if (!array_key_exists($key, self::COLOR)) {
            throw new \InvalidArgumentException("Key doesn't exist");
        }
    }
}
