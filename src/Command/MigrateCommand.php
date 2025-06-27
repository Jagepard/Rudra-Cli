<?php

namespace Rudra\Cli\Command;

use Rudra\Container\Facades\Rudra;
use Rudra\Cli\Command\ConsoleFacade as Cli;
use App\Ship\Utils\Database\LoggerAdapter;

class MigrateCommand extends LoggerAdapter
{
    public function __construct()
    {
        $this->table = "rudra_migrations";
        parent::__construct();
    }

    public function actionIndex(): void
    {
        Cli::printer("Enter container (empty for Ship): ", "magneta");
        $container = ucfirst(str_replace(PHP_EOL, "", Cli::reader()));

        if (!empty($container)) {
            $fileList  = array_slice(scandir(Rudra::config()->get('app.path') . "/app/Containers/" . $container . "/Migration/"), 2);
            $namespace = "App\\Containers\\$container\\Migration\\";
        } else {
            $fileList  = array_slice(scandir(Rudra::config()->get('app.path') . "/app/Ship/Migration/"), 2);
            $namespace = "App\\Ship\\Migration\\";
        }


        if (!$this->isTable()) {
            $this->up();
        }

        foreach ($fileList as $filename) {
            $migrationName = $namespace . strstr($filename, '.', true);

            if ($this->checkLog($migrationName)) {
                Cli::printer("⚠️  $migrationName was migrated" . PHP_EOL, "light_yellow");
            } else {
                (new $migrationName)->up();
                Cli::printer("✅ $migrationName migrated successfully" . PHP_EOL, "light_green");
                $this->writeLog($migrationName);
            }
        }
    }
}
