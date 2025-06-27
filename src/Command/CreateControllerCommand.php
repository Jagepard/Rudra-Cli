<?php

namespace Rudra\Cli\Command;

use ConsoleFacade as Cli;
use App\Ship\Utils\FileCreator;
use Rudra\Container\Facades\Rudra;

class CreateControllerCommand extends FileCreator
{
    /**
     * Creates a file with Seed data
     * -----------------------------
     * Создает файл с данными Seed
     */
    public function actionIndex(): void
    {
        Cli::printer("Enter controller name: ", "magneta");
        $controllerPrefix = ucfirst(str_replace(PHP_EOL, "", Cli::reader()));

        Cli::printer("Enter container: ", "magneta");
        $container = ucfirst(str_replace(PHP_EOL, "", Cli::reader()));

        if (!empty($container)) {
            if (!is_dir(Rudra::config()->get('app.path') . "/app/Containers/$container/")) {
                Cli::printer("⚠️  Container '$container' does not exist" . PHP_EOL, "light_yellow");
                return;
            }
            
            $this->writeFile(
                [Rudra::config()->get('app.path') . "/app/Containers/$container/Controller/", "{$controllerPrefix}Controller.php"],
                $this->createClass($controllerPrefix, $container)
            );

            $this->addRoute($container, $controllerPrefix);
        } else {
            $this->actionIndex();
        }
    }

    /**
     * Creates class data
     * ------------------
     * Создает данные класса
     *
     * @param string $controllerPrefix
     * @param string $container
     * @return string
     */
    private function createClass(string $controllerPrefix, string $container): string
    {
        $url = strtolower("$container/$controllerPrefix");

        if (Rudra::config()->get("attributes")) {
            return <<<EOT
            <?php
            
            namespace App\Containers\\{$container}\Controller;
            
            use App\Containers\\{$container}\\{$container}Controller;
            
            class {$controllerPrefix}Controller extends {$container}Controller
            {
                #[Routing(url: '{$url}', method: 'GET')]
                public function actionIndex(): void
                {
                    dd(__CLASS__);
                }
            }

            EOT;
        }

        return <<<EOT
<?php

namespace App\Containers\\{$container}\Controller;

use App\Containers\\{$container}\\{$container}Controller;

class {$controllerPrefix}Controller extends {$container}Controller
{
    /**
     * @Routing(url = '{$url}', method = 'GET')
     */
    public function actionIndex(): void
    {
        dd(__CLASS__);
    }
}

EOT;
    }

    /**
     * @param string $container
     * @param string $controllerPrefix
     * @return void
     */
    public function addRoute(string $container, string $controllerPrefix): void
    {
        $path   = Rudra::config()->get('app.path') . "/app/Containers/$container/routes.php";
        $routes = require_once $path;
        $namespace = "\App\Containers\\{$container}\\Controller\\{$controllerPrefix}Controller";

        if (!in_array($namespace, $routes)) {
            $contents = file_get_contents($path);
            $contents = str_replace("];", '', $contents);
            file_put_contents($path, $contents);
            $contents = <<<EOT
\t$namespace::class,
];
EOT;
            file_put_contents($path, $contents, FILE_APPEND | LOCK_EX);
        }
    }
}
