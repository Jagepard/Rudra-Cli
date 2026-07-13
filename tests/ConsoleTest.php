<?php declare(strict_types=1);

/**
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 *
 * @author  Korotkov Danila (Jagepard) <jagepard@yandex.ru>
 * @license https://mozilla.org/MPL/2.0/  MPL-2.0
 */

namespace Rudra\Cli\Tests;

use Rudra\Cli\Console;
use Rudra\Cli\ConsoleFacade as Cli;
use Rudra\Exceptions\LogicException;
use Rudra\Cli\Tests\App\Command\TestCommand;

class ConsoleTest extends \PHPUnit\Framework\TestCase
{
    private Console $console;

    protected function setUp(): void
    {
        $this->console = new Console();
    }

    public function testPrinter(): void
    {
        // Test 1: Text without trailing newline
        ob_start();
        $this->console->printer("Test text", "green", "default");
        $output = ob_get_clean();

        $this->assertStringContainsString("Test text", $output);
        $this->assertStringContainsString("\e[32;49m", $output); // Green text, default background
        $this->assertStringContainsString("\e[K", $output);      // Clear to end of line (critical fix)
        $this->assertStringContainsString("\e[0m", $output);     // Reset all attributes

        // Test 2: Text WITH trailing newline (verifies the regex extraction logic)
        ob_start();
        $this->console->printer("Test text\n", "green", "default");
        $outputWithNewline = ob_get_clean();

        $this->assertStringContainsString("Test text", $outputWithNewline);
        // Crucial: the newline MUST come AFTER the reset codes to prevent background bleeding
        $this->assertStringContainsString("\e[K\e[0m\n", $outputWithNewline);
    }

    public function testAddCommandThrowsException()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage("Command testCommand already exist");

        $this->console->addCommand('testCommand', [\stdClass::class, 'actionIndex']);
        $this->console->addCommand('testCommand', [\stdClass::class, 'actionIndex']);
    }

    public function testCheckColorExistsThrowsException()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage("Color invalid_color doesn't exist");

        $reflection = new \ReflectionMethod(Console::class, 'checkColorExists');
        $reflection->setAccessible(true);
        $reflection->invokeArgs($this->console, ['invalid_color']);
    }

    public function testGetRegistry()
    {
        $this->assertIsArray($this->console->getRegistry());
    }

    public function testActionIndexWithValidInput()
    {
        $command = new TestCommand();
        $input   = "AYE\n";
        $stream  = fopen('php://memory', 'r+');
        fwrite($stream, $input);
        rewind($stream);

        Cli::setStdin($stream);

        ob_start();
        $command->actionIndex();
        $rawOutput = ob_get_clean();
        $output    = preg_replace('/\e\[[0-9;]*m/', '', $rawOutput);

        // Assert each part of the message is present
        $this->assertStringContainsString("Are you ready, kids?", $output);
        $this->assertStringContainsString("Say AYE", $output);
        $this->assertStringContainsString("captain:", $output);
        $this->assertStringContainsString("Who lives in a pineapple under the sea?!", $output);
        $this->assertStringContainsString("SPONGEBOB SQUAREPANTS!!!", $output);
        $this->assertStringContainsString("Who lives in a pineapple under the sea?! SPONGEBOB SQUAREPANTS!!!", $output);
    }

    public function testReaderWithValidInput()
    {
        $console = new Console();
        $input   = "Hello, World!\n";
        $stream  = fopen('php://memory', 'r+');
        fwrite($stream, $input);
        rewind($stream);

        $console->setStdin($stream);
        $result = $console->reader();

        $this->assertEquals(trim($input), trim($result));
    }

    public function testReaderWithEmptyInput()
    {
        $console = new Console();
        $input   = "\n";
        $stream  = fopen('php://memory', 'r+');
        fwrite($stream, $input);
        rewind($stream);

        $console->setStdin($stream);
        $result = $console->reader();

        $this->assertEmpty(trim($result));
    }

    public function testInvokeCommandNotFound()
    {
        ob_start();
        $this->console->invoke(['invalidCommand' => []]);
        $rawOutput = ob_get_clean();
        $output    = preg_replace('/\e\[[0-9;]*m/', '', $rawOutput);

        $this->assertStringContainsString("Command \"invalidCommand\" not found", $output);
    }

    public function testInvokeWithExplicitMethod()
    {
        $testCommand = new TestCommand();
        $this->console->addCommand('testCommand', [$testCommand, 'customAction']);

        ob_start();
        $this->console->invoke(['testCommand' => []]);
        $rawOutput = ob_get_clean();
        $output    = preg_replace('/\e\[[0-9;]*m/', '', $rawOutput);

        $this->assertStringContainsString("Custom action called!", $output);
    }
}
