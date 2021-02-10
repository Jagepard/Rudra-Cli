<?php

declare(strict_types=1);

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @license   https://mit-license.org/ MIT
 */

namespace Rudra\Cli;

use Rudra\Container\Traits\FacadeTrait;

/**
 * @method static void printer(string $text, string $fg = "default", string $bg = "default")
 * @method static void addCommand($name, $command)
 * @method static void run($inputArgs)
 * @method static array getRegistry()
 *
 * @see Router
 */
class ConsoleFacade
{
    use FacadeTrait;

    public static function init()
    {
        ConsoleFacade::addCommand("create:seed", [Commands\CreateSeedCommand::class]);
        ConsoleFacade::addCommand("create:migration", [Commands\CreateMigrationCommand::class]);
        ConsoleFacade::addCommand("seed", [Commands\SeedCommand::class]);
        ConsoleFacade::addCommand("migrate", [Commands\MigrateCommand::class]);
        ConsoleFacade::addCommand("crud", [Commands\AddCrudCommand::class, "actionAdd"]);
        ConsoleFacade::addCommand("events", [Commands\EventsCommand::class]);
        ConsoleFacade::addCommand("routes", [Commands\RouterCommand::class]);
        ConsoleFacade::addCommand("routes:bundle", [Commands\RouterCommand::class, "actionBundle"]);
        ConsoleFacade::addCommand("bcrypt", [Commands\BcryptCommand::class]);
        ConsoleFacade::addCommand("serve", [Commands\ServeCommand::class]);
        ConsoleFacade::addCommand("help", [Commands\ConsoleCommand::class]);
    }
}
