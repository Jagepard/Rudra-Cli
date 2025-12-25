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

## License

This project is licensed under the **Mozilla Public License 2.0 (MPL-2.0)** — a free, open-source license that:

- Requires preservation of copyright and license notices,
- Allows commercial and non-commercial use,
- Requires that any modifications to the original files remain open under MPL-2.0,
- Permits combining with proprietary code in larger works.

📄 Full license text: [LICENSE](./LICENSE)  
🌐 Official MPL-2.0 page: https://mozilla.org/MPL/2.0/

--------------------------
Проект распространяется под лицензией **Mozilla Public License 2.0 (MPL-2.0)**. Это означает:
 - Вы можете свободно использовать, изменять и распространять код.
 - При изменении файлов, содержащих исходный код из этого репозитория, вы обязаны оставить их открытыми под той же лицензией.
 - Вы **обязаны сохранять уведомления об авторстве** и ссылку на оригинал.
 - Вы можете встраивать код в проприетарные проекты, если исходные файлы остаются под MPL.

📄  Полный текст лицензии (на английском): [LICENSE](./LICENSE)  
🌐 Официальная страница: https://mozilla.org/MPL/2.0/