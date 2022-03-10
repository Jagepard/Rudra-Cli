<?php

declare(strict_types = 1);

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @license   https://mit-license.org/ MIT
 */

namespace Rudra\Cli;

class Console implements ConsoleInterface
{
    /*
     * Colors of text decoration in the console
     * ----------------------------------------
     * Цвета оформления текста в консоли
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

    /**
     * @var array
     *
     * Command registry
     * ----------------
     * Реестр команд
     */
    private array $registry = [];

    /**
     * @param string $text
     * @param string $fg
     * @param string $bg
     *
     * Prints formatted text
     * ---------------------
     * Печатает отфармотированный текст
     */
    public function printer(string $text, string $fg = "default", string $bg = "default"): void
    {
        $this->checkColorExists($fg);
        $this->checkColorExists($bg);

        printf("\e[%s;%sm{$text}\e[0m", self::COLOR[$fg], self::COLOR[$bg] + 10);
    }

    /**
     * @return false|string
     *
     * Get the data entered in the console
     * -----------------------------------
     * Получет данные введенные в консоли
     */
    public function reader(): string
    {
        return fgets(fopen("php://stdin","r"));
    }

    /**
     * @param $name
     * @param $command
     *
     * Adds a command to the registry
     * ------------------------------
     * Добавляет команду в реестр
     */
    public function addCommand($name, $command): void
    {
        if (array_key_exists($name, $this->registry)) {
            throw new \InvalidArgumentException("Command $name already exist");
        }

        $this->registry[$name] = $command;
    }

    /**
     * @param $inputArgs
     *
     * Calls command methods
     * ---------------------
     * Вызывает методы команды
     */
    public function invoke($inputArgs): void
    {
        $firstKey = array_key_first($inputArgs);

        if (array_key_exists($firstKey, $this->registry)) {
            $class  = new $this->registry[$firstKey][0];
            $method = $this->registry[$firstKey][1] ?? "actionIndex";

            $class->$method();
        } else {
            $this->printer("Command \"$firstKey\" not found" . PHP_EOL, 'light_yellow');
        }
    }

    /**
     * @return array
     *
     * Retrieves the commands registry
     * ----------------------
     * Получает реестр команд
     */
    public function getRegistry(): array
    {
        return $this->registry;
    }

    /**
     * @param string $key
     *
     * Checks if there is a color in the array
     * ---------------------------------------
     * Проверяет есть ли цвет в массиве
     */
    private function checkColorExists(string $key): void
    {
        if (!array_key_exists($key, self::COLOR)) {
            throw new \InvalidArgumentException("Color $key doesn't exist");
        }
    }
}
