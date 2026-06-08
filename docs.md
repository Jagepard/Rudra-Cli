## Table of contents
- [Rudra\Cli\Console](#rudra_cli_console)
- [Rudra\Cli\ConsoleFacade](#rudra_cli_consolefacade)
- [Rudra\Cli\ConsoleInterface](#rudra_cli_consoleinterface)


---



<a id="rudra_cli_console"></a>

### Class: Rudra\Cli\Console
| Visibility | Function |
|:-----------|:---------|
| public | `setStdin(mixed $stream): void`<br> |
| public | `printer(string $text, string $fg, string $bg): void`<br>Prints formatted text with foreground and background colors |
| public | `reader(): string`<br>Get the data entered in the console |
| public | `addCommand(string $name, array $command): void`<br> |
| public | `invoke(array $inputArgs): void`<br>Calls command methods |
| public | `getRegistry(): array`<br> |
| private | `checkColorExists(string $key): void`<br> |


<a id="rudra_cli_consolefacade"></a>

### Class: Rudra\Cli\ConsoleFacade
| Visibility | Function |
|:-----------|:---------|
| public static | `__callStatic(string $method, array $parameters): mixed`<br>Handles static method calls for the Facade class<br>It dynamically resolves the underlying class name by removing "Facade" from the class name<br>If the resolved class does not exist, it attempts to clean up the class name by removing spaces<br>If the resolved class is not already registered in the container, it registers it<br>Finally, it delegates the static method call to the resolved class instance |


<a id="rudra_cli_consoleinterface"></a>

### Class: Rudra\Cli\ConsoleInterface
| Visibility | Function |
|:-----------|:---------|
| abstract public | `printer(string $text, string $fg, string $bg): void`<br> |
| abstract public | `reader(): string`<br> |
| abstract public | `addCommand(string $name, array $command): void`<br> |
| abstract public | `invoke(array $inputArgs): void`<br> |
| abstract public | `getRegistry(): array`<br> |


---

###### created with [Rudra-Documentation-Collector](https://github.com/Jagepard/Rudra-Documentation-Collector)
