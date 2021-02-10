<?php

namespace Rudra\Cli\Commands;

use Rudra\Cli\ConsoleFacade as Cli;

class CreateMigrationCommand
{
    public function actionIndex()
    {
        Cli::printer("Enter table name: ", "cyan");
        $table = trim(fgets(fopen("php://stdin","r")));
        $date = date("_dmYHis");
        $className = ucfirst($table) . $date;

        $this->createFile("/home/d/devs/php/Rudra-Docs/db/Migrations/{$className}_migration.php", $this->actionCreate($className, $table));
    }

    public function actionCreate(string $className, string $table)
    {
        return <<<EOT
<?php

namespace Db\Migrations;

use Rudra\Container\Facades\Rudra;

class {$className}_migration
{
    public function up()
    {
        \$table = "$table";

        \$query = Rudra::get("MySQL")->prepare("            
            CREATE TABLE {\$table} ( 
            `id` INT NOT NULL AUTO_INCREMENT ,
            , PRIMARY KEY (`id`)) ENGINE = InnoDB
        ");
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
