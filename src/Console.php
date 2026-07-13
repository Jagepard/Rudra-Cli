<?php declare(strict_types = 1);

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
    // Colors of text decoration in the console
    public const array COLOR = [
        "default"       => 39,
        "black"         => 30,
        "red"           => 31,
        "green"         => 32,
        "yellow"        => 33,
        "blue"          => 34,
        "magenta"       => 35,
        "cyan"          => 36,
        "light_gray"    => 37,
        "dark_gray"     => 90,
        "light_red"     => 91,
        "light_green"   => 92,
        "light_yellow"  => 93,
        "light_blue"    => 94,
        "light_magenta" => 95,
        "light_cyan"    => 96,
        "white"         => 97,
    ];

    private array $registry = [];

    /** @var resource|null */
    private mixed $stdin    = null;

    /**
     * @throws \InvalidArgumentException
     */
    public function setStdin(mixed $stream): void
    {
        if ($stream !== null && !is_resource($stream)) {
            throw new \InvalidArgumentException('Argument #1 ($stream) must be of type resource or null');
        }
        
        $this->stdin = $stream;
    }

    /**
     * Prints formatted text with foreground and background colors
     */
    #[\Override]
    public function printer(string $text, string $fg = "default", string $bg = "default"): void
    {
        $this->checkColorExists($fg);
        $this->checkColorExists($bg);

        $fgCode = self::COLOR[$fg];
        $bgCode = self::COLOR[$bg] + 10;

        // Remove trailing newlines
        $text = rtrim($text, "\n\r");
        
        // \e[49m explicitly resets background color
        echo "\e[{$fgCode};{$bgCode}m{$text}\e[49m\e[0m";
    }

    /**
     * Get the data entered in the console
     * 
     * @throws LogicException
     */
    #[\Override]
    public function reader(): string
    {
        $this->stdin ??= fopen("php://stdin", "r");
        
        if ($this->stdin === false) {
            throw new LogicException('Failed to open stdin stream');
        }
        
        $result = fgets($this->stdin);

        if ($result === false) {
            throw new LogicException('Failed to read from stdin or EOF reached');
        }

        return $result;
    }

    /**
     * @throws LogicException
     */
    #[\Override]
    public function addCommand(string $name, array $command): void
    {
        if (array_key_exists($name, $this->registry)) {
            throw new LogicException("Command $name already exists");
        }
        
        $this->registry[$name] = $command;
    }

    /**
     * Calls command methods
     */
    #[\Override]
    public function invoke(array $inputArgs): void
    {
        $firstKey = array_key_first($inputArgs);

        if ($firstKey === null) {
            $this->printer("⚠️  No command provided" . PHP_EOL, 'light_yellow');
            return;
        }

        if (!array_key_exists($firstKey, $this->registry)) {
            $this->printer("⚠️  Command \"$firstKey\" not found" . PHP_EOL, 'light_yellow');
            return;
        }

        $class  = new $this->registry[$firstKey][0];
        $method = $this->registry[$firstKey][1] ?? "actionIndex";

        $class->$method();
    }

    /**
     * @return array<string, array>
     */
    #[\Override]
    public function getRegistry(): array
    {
        return $this->registry;
    }

    /**
     * @throws LogicException
     */
    private function checkColorExists(string $key): void
    {
        if (!array_key_exists($key, self::COLOR)) {
            throw new LogicException("Color $key doesn't exist");
        }
    }
}
