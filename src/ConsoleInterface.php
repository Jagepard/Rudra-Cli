<?php

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @license   https://mit-license.org/ MIT
 */


namespace Rudra\Cli;

interface ConsoleInterface
{
    /**
     * @param string $text
     * @param string $fg
     * @param string $bg
     *
     * Prints formatted text
     * ---------------------
     * Печатает отфармотированный текст
     */
    public function printer(string $text, string $fg = "default", string $bg = "default"): void;

    /**
     * @return false|string
     *
     * Get the data entered in the console
     * -----------------------------------
     * Получет данные введенные в консоли
     */
    public function reader(): string;

    /**
     * @param $name
     * @param $command
     *
     * Adds a command to the registry
     * ------------------------------
     * Добавляет команду в реестр
     */
    public function addCommand($name, $command): void;

    /**
     * @param $inputArgs
     *
     * Calls command methods
     * ---------------------
     * Вызывает методы команды
     */
    public function invoke($inputArgs): void;

    /**
     * @return array
     *
     * Retrieves the commands registry
     * ----------------------
     * Получает реестр команд
     */
    public function getRegistry(): array;
}
