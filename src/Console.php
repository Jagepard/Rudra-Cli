<?php

declare(strict_types=1);

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @license   https://mit-license.org/ MIT
 */

namespace Rudra\Cli;

class Console
{
    /**
     * First key - Foreground color
     * Second key - Background color
     */
    const COLOR = [
        "default" => [39, 49],
        "black" => [30, 40],
        "red" => [31, 41],
        "green" => [32, 42],
        "yellow" => [33, 43],
        "blue" => [34, 44],
        "magneta" => [35, 45],
        "cyan" => [36, 46],
        "light_gray" => [37, 47],
        "dark_gray" => [90, 100],
        "light_red" => [91, 101],
        "light_green" => [92, 102],
        "light_yellow" => [93, 103],
        "light_blue" => [94, 104],
        "light_magneta" => [95, 105],
        "light_cyan" => [96, 106],
        "white" => [97, 107],
    ];

    private array $registry = [];

    public function printer(string $text, string $fg = "default", string $bg = "default"): void
    {
        $this->checkKey($fg);
        $this->checkKey($bg);

        $fg = self::COLOR[$fg][0];
        $bg = self::COLOR[$bg][1];

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
