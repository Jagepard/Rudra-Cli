<?php

namespace Rudra\Cli\Commands;

use Rudra\Cli\ConsoleFacade as Cli;

class CreateSeedCommand
{
    public function actionIndex()
    {
        Cli::printer("Enter table name: ", "cyan");
        $table = trim(fgets(fopen("php://stdin","r")));

        $date = date("_dmYHis");
        $className = ucfirst($table) . $date;

        $this->createFile("/home/d/devs/php/Rudra-Docs/db/Seeds/{$className}_seed.php", $this->actionCreate($className, $table));
    }

    public function actionCreate(string $className, string $table)
    {
        return <<<EOT
<?php

namespace Db\Seeds;

use Db\AbstractSeed;

class {$className}_seed extends AbstractSeed
{
    public function create()
    {
        \$table = "$table";
        \$fields = [
            
        ];

        \$this->execute(\$table, \$fields);
    }
}
EOT;
    }

    private function createFile($path, $callable)
    {
        if (!file_exists($path)) {
            Cli::printer("The file $path was created", "blue");
            file_put_contents($path, $callable);
        } else {
            Cli::printer("The file $path is already exists", "light_green");
        }
    }
}
