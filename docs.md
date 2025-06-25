## Table of contents
- [Rudra\Cli\Console](#rudra_cli_console)
- [Rudra\Cli\ConsoleFacade](#rudra_cli_consolefacade)
- [Rudra\Cli\ConsoleInterface](#rudra_cli_consoleinterface)
<hr>

<a id="rudra_cli_console"></a>

### Class: Rudra\Cli\Console
| Visibility | Function |
|:-----------|:---------|
| public | `setStdin( $stream)`<br> |
| public | `printer(string $text, string $fg, string $bg): void`<br>Prints formatted text |
| public | `reader(): string`<br>Get the data entered in the console |
| public | `addCommand(string $name, array $command): void`<br>Adds a command to the registry |
| public | `invoke(array $inputArgs): void`<br>Calls command methods |
| public | `getRegistry(): array`<br>Retrieves the commands registry |
| private | `checkColorExists(string $key): void`<br>Checks if there is a color in the array |


<a id="rudra_cli_consolefacade"></a>

### Class: Rudra\Cli\ConsoleFacade
| Visibility | Function |
|:-----------|:---------|
| public static | `__callStatic(string $method, array $parameters): ?mixed`<br> |


<a id="rudra_cli_consoleinterface"></a>

### Class: Rudra\Cli\ConsoleInterface
| Visibility | Function |
|:-----------|:---------|
| abstract public | `printer(string $text, string $fg, string $bg): void`<br>Prints formatted text |
| abstract public | `reader(): string`<br>Get the data entered in the console |
| abstract public | `addCommand(string $name, array $command): void`<br>Adds a command to the registry |
| abstract public | `invoke(array $inputArgs): void`<br>Calls command methods |
| abstract public | `getRegistry(): array`<br>Retrieves the commands registry |
<hr>

###### created with [Rudra-Documentation-Collector](#https://github.com/Jagepard/Rudra-Documentation-Collector)
