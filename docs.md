## Table of contents
- [Rudra\Cli\Console](#rudra_cli_console)
- [Rudra\Cli\ConsoleFacade](#rudra_cli_consolefacade)
- [Rudra\Cli\ConsoleInterface](#rudra_cli_consoleinterface)
<hr>

<a id="rudra_cli_console"></a>

### Class: Rudra\Cli\Console
##### implements [Rudra\Cli\ConsoleInterface](#rudra_cli_consoleinterface)
| Visibility | Function |
|:-----------|:---------|
|public|<em><strong>printer</strong>( string $text  string $fg  string $bg ): void</em><br>Prints formatted text|
|public|<em><strong>reader</strong>(): string</em><br>Get the data entered in the console|
|public|<em><strong>addCommand</strong>(  $name   $command ): void</em><br>Adds a command to the registry|
|public|<em><strong>invoke</strong>(  $inputArgs ): void</em><br>Calls command methods|
|public|<em><strong>getRegistry</strong>(): array</em><br>Retrieves the commands registry|
|private|<em><strong>checkColorExists</strong>( string $key ): void</em><br>Checks if there is a color in the array|


<a id="rudra_cli_consolefacade"></a>

### Class: Rudra\Cli\ConsoleFacade
| Visibility | Function |
|:-----------|:---------|
|public static|<em><strong>__callStatic</strong>( string $method  array $parameters ): mixed</em><br>|


<a id="rudra_cli_consoleinterface"></a>

### Class: Rudra\Cli\ConsoleInterface
| Visibility | Function |
|:-----------|:---------|
|abstract public|<em><strong>printer</strong>( string $text  string $fg  string $bg ): void</em><br>|
|abstract public|<em><strong>reader</strong>(): string</em><br>|
|abstract public|<em><strong>addCommand</strong>(  $name   $command ): void</em><br>|
|abstract public|<em><strong>invoke</strong>(  $inputArgs ): void</em><br>|
|abstract public|<em><strong>getRegistry</strong>(): array</em><br>|
<hr>

###### created with [Rudra-Documentation-Collector](#https://github.com/Jagepard/Rudra-Documentation-Collector)
