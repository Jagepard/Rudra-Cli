[![PHPunit](https://github.com/Jagepard/Rudra-Cli/actions/workflows/php.yml/badge.svg)](https://github.com/Jagepard/Rudra-Cli/actions/workflows/php.yml)
[![Maintainability](https://qlty.sh/badges/1935b814-5435-4137-8d07-9e1e8e22b474/maintainability.svg)](https://qlty.sh/gh/Jagepard/projects/Rudra-Cli)
[![CodeFactor](https://www.codefactor.io/repository/github/Jagepard/Rudra-Cli/badge)](https://www.codefactor.io/repository/github/Jagepard/Rudra-Cli)
[![Coverage Status](https://coveralls.io/repos/github/Jagepard/Rudra-Cli/badge.svg?branch=master)](https://coveralls.io/github/Jagepard/Rudra-Cli?branch=master)
-----

# Rudra-Cli | [API](https://github.com/Jagepard/Rudra-Cli/blob/main/docs.md)

```php
use Rudra\Cli\Console;
use Rudra\Cli\Tests\App\Command\TestCommand;

parse_str(implode('&', array_slice($argv, 1)), $inputArgs);

$console = new Console();
$console->addCommand('spongebob', [TestCommand::class]);
$console->addCommand('second', [TestCommand::class, "actionSecond"]);

$console->invoke($inputArgs);
```
```php rudra spongebob```

- Вы готовы дети?  Скажите ДА капитан: да
- Не слышу!!!(

```php rudra spongebob```
- Вы готовы дети?  Скажите ДА капитан: ДА
- Кто обетает на дне океана?! SPONGEBOB SQUAREPANTS!!!