<?php

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @license   https://mit-license.org/ MIT
 */


namespace Rudra\Cli;

interface ConsoleInterface
{
    /**
     * Prints formatted text
     * ---------------------
     * Печатает отфармотированный текст
     * 
     * @param string $text
     * @param string $fg
     * @param string $bg
     */
    public function printer(string $text, string $fg = "default", string $bg = "default"): void;

    /**
     * Get the data entered in the console
     * -----------------------------------
     * Получет данные введенные в консоли
     * 
     * @return false|string
     */
    public function reader(): string;

    /**
     * Adds a command to the registry
     * ------------------------------
     * Добавляет команду в реестр
     * 
     * @param $name
     * @param $command
     */
    public function addCommand($name, $command): void;

    /**
     * Calls command methods
     * ---------------------
     * Вызывает методы команды
     * 
     * @param $inputArgs
     */
    public function invoke($inputArgs): void;

    /**
     * Retrieves the commands registry
     * ----------------------
     * Получает реестр команд
     * 
     * @return array
     */
    public function getRegistry(): array;
}
