[![PHPunit](https://github.com/Jagepard/Rudra-Cli/actions/workflows/php.yml/badge.svg)](https://github.com/Jagepard/Rudra-Cli/actions/workflows/php.yml)
[![Maintainability](https://qlty.sh/badges/1935b814-5435-4137-8d07-9e1e8e22b474/maintainability.svg)](https://qlty.sh/gh/Jagepard/projects/Rudra-Cli)
[![CodeFactor](https://www.codefactor.io/repository/github/Jagepard/Rudra-Cli/badge)](https://www.codefactor.io/repository/github/Jagepard/Rudra-Cli)
-----

# Rudra-Cli | [API](https://github.com/Jagepard/Rudra-Cli/blob/main/docs.md)

The CLI component of **Rudra Framework**. Lightweight, straightforward, built on the KISS principle. No hidden dependencies, no magic — just clean, predictable command routing.

#### Install
```composer require rudra/cli```
#### Usage
Create a file named ```rudra```:

```php
#!/usr/bin/php
<?php

if (php_sapi_name() !== 'cli') {
    exit;
}

require __DIR__ . '/vendor/autoload.php';

use Rudra\Cli\Console;
use Rudra\Cli\Tests\App\Command\TestCommand;

parse_str(implode('&', array_slice($argv, 1)), $inputArgs);

$console = new Console();
$console->addCommand('spongebob', [TestCommand::class]);
$console->addCommand('second', [TestCommand::class, "actionSecond"]);

$console->invoke($inputArgs);
```
##### Run via PHP:
```php rudra spongebob```

- Are you ready, kids? Say AYE, captain: yes
- I can't hear you!!!

```php rudra spongebob```
- Are you ready, kids? Say AYE, captain: AYE
- Who lives in a pineapple under the sea?! SPONGEBOB SQUAREPANTS!!!

##### Or make it executable and run directly:
```
chmod +x rudra
./rudra spongebob
```
## License

This project is licensed under the **Mozilla Public License 2.0 (MPL-2.0)** — a free, open-source license that:

- Requires preservation of copyright and license notices,
- Allows commercial and non-commercial use,
- Requires that any modifications to the original files remain open under MPL-2.0,
- Permits combining with proprietary code in larger works.

📄 Full license text: [LICENSE](./LICENSE)  
🌐 Official MPL-2.0 page: https://mozilla.org/MPL/2.0/