## Table of contents
- [Rudra\Cli\Console](#rudra_cli_console)
- [Rudra\Cli\ConsoleFacade](#rudra_cli_consolefacade)
- [Rudra\Cli\ConsoleInterface](#rudra_cli_consoleinterface)
<hr>

<a id="rudra_cli_console"></a>

### Class: Rudra\Cli\Console
| Visibility | Function |
|:-----------|:---------|
| public | `setStdin(?mixed $stream): void`<br> |
| public | `printer(string $text, string $fg, string $bg): void`<br>Prints formatted text with foreground and background colors.<br>----------------<br>Выводит форматированный текст с цветами переднего плана и фона. |
| public | `reader(): string`<br>Get the data entered in the console.<br>----------------<br>Получает данные, введённые в консоли. |
| public | `addCommand(string $name, array $command): void`<br>Adds a command to the registry<br>----------------<br>Добавляет команду в реестр. |
| public | `invoke(array $inputArgs): void`<br>Calls command methods<br>----------------<br>Вызывает методы команды. |
| public | `getRegistry(): array`<br>Retrieves the commands registry<br>----------------<br>Получает реестр команд. |
| private | `checkColorExists(string $key): void`<br>Checks if there is a color in the array<br>----------------<br>Проверяет, есть ли цвет в массиве |


<a id="rudra_cli_consolefacade"></a>

### Class: Rudra\Cli\ConsoleFacade
| Visibility | Function |
|:-----------|:---------|
| public static | `__callStatic(string $method, array $parameters): ?mixed`<br>Handles static method calls for the Facade class.<br>It dynamically resolves the underlying class name by removing "Facade" from the class name.<br>If the resolved class does not exist, it attempts to clean up the class name by removing spaces.<br>If the resolved class is not already registered in the container, it registers it.<br>Finally, it delegates the static method call to the resolved class instance.<br>-------------------------<br>Обрабатывает статические вызовы методов для класса Facade.<br>Динамически разрешает имя базового класса, удаляя "Facade" из имени класса.<br>Если разрешённый класс не существует, пытается очистить имя класса, удаляя пробелы.<br>Если разрешённый класс ещё не зарегистрирован в контейнере, он регистрируется.<br>В конце делегирует статический вызов метода экземпляру разрешённого класса. |


<a id="rudra_cli_consoleinterface"></a>

### Class: Rudra\Cli\ConsoleInterface
| Visibility | Function |
|:-----------|:---------|
| abstract public | `printer(string $text, string $fg, string $bg): void`<br>Prints formatted text with foreground and background colors.<br>----------------<br>Выводит форматированный текст с цветами переднего плана и фона. |
| abstract public | `reader(): string`<br>Get the data entered in the console.<br>----------------<br>Получает данные, введённые в консоли. |
| abstract public | `addCommand(string $name, array $command): void`<br>Adds a command to the registry<br>----------------<br>Добавляет команду в реестр. |
| abstract public | `invoke(array $inputArgs): void`<br>Calls command methods<br>----------------<br>Вызывает методы команды. |
| abstract public | `getRegistry(): array`<br>Retrieves the commands registry<br>----------------<br>Получает реестр команд. |
<hr>

###### created with [Rudra-Documentation-Collector](#https://github.com/Jagepard/Rudra-Documentation-Collector)
