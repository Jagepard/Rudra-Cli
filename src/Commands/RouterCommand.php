<?php

namespace Rudra\Cli\Commands;

use Rudra\Cli\ConsoleFacade as Cli;
use Rudra\Container\Facades\Rudra;

class RouterCommand
{
    public function actionIndex()
    {
        foreach (Rudra::config()->get('bundles') as $bundle => $item) {
            $mask = "|%-5.5s |%-35.35s|%-35.35s|%-20.20s| x |\n";
            Cli::printer(strtoupper($bundle));
            printf("\e[1;35m" . $mask . "\e[m", " ", "route", "controller", "action");
            $this->getTable($this->getRoutes($bundle));
        }
    }

    public function actionBundle()
    {
        Cli::printer("Enter bundle name: ");
        $line = fgets(fopen("php://stdin","r"));
        $mask = "|%-5.5s |%-35.35s|%-35.35s|%-20.20s| x |\n";
        printf("\e[1;35m" . $mask . "\e[m", " ", "route", "controller", "action");
        $this->getTable($this->getRoutes(trim($line)));
    }

    protected function getTable(array $data)
    {
        $mask = "|%-5.5s |%-35.35s|%-35.35s|%-20.20s| x |\n";
        $i = 1;

        foreach ($data as $name => $routes) {
            if (isset($name)) {
                printf("\e[1;36m" . $mask . "\e[m", $i, $name, $routes[0], $routes[1] ?? "actionIndex");
            } else {
                printf("\e[1;36m" . $mask . "\e[m", $i, " ", $routes[0], $routes[1] ?? "actionIndex");
            }

            $i++;
        }
    }

    protected function getRoutes(string $bundle)//: array
    {
        $path = "./app/" . ucfirst($bundle) . "/routes";

        if (file_exists($path . ".php")) {
            return require_once $path . ".php";
        }
    }
}
