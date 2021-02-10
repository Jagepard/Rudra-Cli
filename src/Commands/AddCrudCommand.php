<?php

namespace Rudra\Cli\Commands;

use Rudra\Cli\ConsoleFacade as Cli;
use Rudra\Container\Facades\Rudra;

class AddCrudCommand
{
    public function actionAdd()
    {
        Cli::printer("Enter Bundle name: ", "cyan");
        $bundleName = trim(fgets(fopen("php://stdin","r")));
        $bundlePath = Rudra::config()->get('app.path') . '/app/' . $bundleName;
        $bundleUri = strtolower($bundleName);

        Cli::printer("Enter table name: ", "cyan");
        $table = trim(fgets(fopen("php://stdin","r")));
        $uTable = ucfirst($table);

        $names = [
            "bundleName" => $bundleName,
            "bundleUri"  => $bundleUri,
            "table"      => $table,
            "uTable"     => $uTable
        ];

        $this->createFile(["$bundlePath/", "{$bundleName}Controller.php"], $this->baseControllerContent($names));

        $this->createFile(["$bundlePath/Controllers/", "{$uTable}Controller.php"], $this->controllerContent($names));
        $this->createFile(["$bundlePath/UI/tmpl/", "layout.tmpl.php"], $this->createLayout($bundleUri));
        $this->createFile(["$bundlePath/UI/tmpl/", "{$table}_read.tmpl.php"], $this->readUiContent($names));
        $this->createFile(["$bundlePath/UI/tmpl/", "{$table}_create.tmpl.php"], $this->createUiContent($names));
        $this->createFile(["$bundlePath/UI/tmpl/", "{$table}_update.tmpl.php"], $this->updateUiContent($names));
        $this->createFile(["$bundlePath/UI/", "CrudTable.php"], $this->crudTable($bundleName));
        $this->createFile(["$bundlePath/UI/", "CrudCreateForm.php"], $this->crudCreateForm($bundleName));
        $this->createFile(["$bundlePath/UI/", "CrudUpdateForm.php"], $this->crudUpdateForm($bundleName));
        $this->createFile(["$bundlePath/Models/", "{$uTable}.php"], $this->modelContent($names));
        Cli::printer("Model, Controller and templates has added", "white", "blue");

        $crudsPath = Rudra::config()->get('app.path') . "/app/Data/cruds.php";

            $cruds = require_once $crudsPath;

        if (!in_array($table, $cruds)) {
            $contents = file_get_contents($crudsPath);
            $contents = str_replace("];", '', $contents);
            file_put_contents($crudsPath, $contents);
            $contents = <<<EOT
    "$table",
];
EOT;
            file_put_contents($crudsPath, $contents, FILE_APPEND | LOCK_EX);
        }

        $routesPath = "$bundlePath/routes.php";
        $contents = <<<EOT
<?php

return [
];
EOT;
        if (!file_exists($routesPath)) file_put_contents($routesPath, $contents);

        $routes = require_once $routesPath;

        if (!array_key_exists("$bundleUri/$table", $routes)) {
            $contents = file_get_contents("$bundlePath/routes.php");
            $contents = str_replace("];", '', $contents);
            file_put_contents($routesPath, $contents);
            $contents = <<<EOT
    // CRUD $table routes 
    '$bundleUri/$table' => ['{$uTable}Controller', 'read{$uTable}'],
    '$bundleUri/$table/page' => ['{$uTable}Controller', 'read{$uTable}', 1],
    '$bundleUri/$table/page/{id}' => ['{$uTable}Controller', 'read{$uTable}', 2],
    '$bundleUri/$table/update/{id}' => ['{$uTable}Controller', 'edit{$uTable}'],
    '$bundleUri/$table/update::POST' => ['{$uTable}Controller', 'update{$uTable}'],
    '$bundleUri/$table/create' => ['{$uTable}Controller', 'add{$uTable}'],
    '$bundleUri/$table/create::POST' => ['{$uTable}Controller', 'create{$uTable}'],
    '$bundleUri/$table/delete/{id}' => ['{$uTable}Controller', 'delete{$uTable}'],
    '$bundleUri/$table/search::POST' => ['{$uTable}Controller', 'search{$uTable}'],
];
EOT;
            file_put_contents($routesPath, $contents, FILE_APPEND | LOCK_EX);
            Cli::printer("CRUD added", "white", "blue");
        }
    }

    private function createFile($path, $callable)
    {
        if (!is_dir($path[0])) mkdir($path[0], 0755, true);

        if (!file_exists($path[0] . $path[1])) {
            Cli::printer("The file $path[0] $path[1] was created", "blue");
            file_put_contents($path[0] . $path[1], $callable);
        } else {
            Cli::printer("The file $path[0] $path[1] is already exists", "light_green");
        }
    }

    public function controllerContent(array $names)
    {
        extract($names);

        return <<<EOT
<?php

namespace App\\$bundleName\Controllers;

use Rudra\Pagination;
use App\\$bundleName\\{$bundleName}Controller;
use App\\$bundleName\Models\\$uTable;
use Rudra\Redirect\RedirectFacade as Redirect;
use Rudra\View\ViewFacade as View;

use Rudra\Container\Facades\Request;

class {$uTable}Controller extends {$bundleName}Controller
{
    protected string \$table = "$table";

    /**
     * @Routing(url = '{$bundleUri}/$table')
     * @Routing(url = '{$bundleUri}/$table/page')
     * @Routing(url = '{$bundleUri}/$table/page/{id}')
     */
    public function read$uTable(\$id = 1)
    {
        \$fields     = null;
        \$pagination = new Pagination(\$id, 10, $uTable::numRows());
        
        View::render("layout", array_merge(\$this->data->get(), [
            "content" => View::view("{\$this->table}_read", [
                "fields" => $uTable::getFields(\$fields),
                "rows"   => $uTable::getAllPerPage(\$pagination, \$fields),
                "links"  => \$pagination->getLinks(),
                "page"   => \$id
            ]),
        ]));
    }
    
    /**
     * @Routing(url = '{$bundleUri}/$table/search', method = 'POST')
     */
    public function search$uTable()
    {
        \$fields = null;
        \$search = trim(Request::post()->get("search"));
        \$column = "id";

        View::render("layout", array_merge(\$this->data->get(), [
            "content" => View::view("{\$this->table}_read", [
                "fields" => $uTable::getFields(\$fields),
                "rows"   => $uTable::search(\$search, \$column, \$fields),
                "links"  => [],
            ]),
        ]));
    }

    /**
     * @Routing(url = '{$bundleUri}/$table/update/{id}')
     */
    public function edit$uTable(\$id)
    {
        View::render("layout", array_merge(\$this->data->get(), [
            "content" => View::view("{\$this->table}_update", [
                "item" => $uTable::find(\$id),
                "columns" => $uTable::getColumns()])
        ]));
    }
    
    /**
     * @Routing(url = '{$bundleUri}/$table/update', method = 'POST')
     */
    public function update$uTable()
    {
        \$fields = $uTable::getFields();
        \$updateArr = [];

        foreach (\$fields as \$field) {
            if ((\$field === "updated_at")) {
                \$updateArr[\$field] = date('Y-m-d H:i:s');
                continue;
            }
            
            \$updateArr[\$field] = Request::post()->get(\$field);
        }

        $uTable::update(\$updateArr);
        Redirect::run("{$bundleUri}/{\$this->table}");
    }

    /**
     * @Routing(url = '{$bundleUri}/$table/create')
     */
    public function add$uTable()
    {
        View::render("layout", array_merge(\$this->data->get(), [
            "content" => View::view("{\$this->table}_create", [
            "columns" => $uTable::getColumns()]),
        ]));
    }

    /**
     * @Routing(url = '{$bundleUri}/$table/create', method = 'POST')
     */
    public function create$uTable()
    {
        \$fields = $uTable::getFields();
        array_shift(\$fields);
        \$createArr = [];

        foreach (\$fields as \$field) {
            if ((\$field === "created_at") or (\$field === "updated_at")) {
                \$createArr[\$field] = date('Y-m-d H:i:s');
                continue;
            }
            
            \$createArr[\$field] = Request::post()->get(\$field);
        }

        $uTable::create(\$createArr);
        Redirect::run("{$bundleUri}/{\$this->table}");
    }

    /**
     * @Routing(url = '{$bundleUri}/$table/delete/{id}')
     */
    public function delete$uTable(\$id)
    {
        $uTable::delete(\$id);
        Redirect::run("{$bundleUri}/{\$this->table}");
    }
}
EOT;
    }


    public function baseControllerContent(array $names)
    {
        extract($names);

        return <<<EOT
<?php

namespace App\\$bundleName;

use App\AppController;
use App\Auth\Middleware\AuthMiddleware;
use Rudra\EventDispatcher\EventDispatcherFacade as Dispatcher;
use Rudra\View\ViewFacade as View;

class {$bundleName}Controller extends AppController
{
    public function init()
    {
//        \$this->middleware([[AuthMiddleware::class]], true);
        Dispatcher::dispatch('RoleAccess', 'admin');

        View::setup([
            "base.path"      => dirname(__DIR__) . '/',
            "engine"         => "native",
            "view.path"      => "$bundleName/UI/tmpl",
            "file.extension" => "tmpl.php"
        ]);

        \$this->data->set([
            "title" => "Rudra Framework"
        ]);
    }
}
EOT;
    }

    public function modelContent(array $names)
    {
        extract($names);

        return <<<EOT
<?php

namespace App\\$bundleName\Models;

use App\Model;

class $uTable extends Model
{
    public static string \$table = "$table";
}
EOT;
    }

    public function readUiContent(array $names)
    {
        extract($names);

        return <<<EOT
<?php
    use Rudra\Container\Facades\Rudra;
    use Rudra\Container\Facades\Session;
    use App\\$bundleName\UI\CrudTable;
?>
<main>
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">$table</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0" action="<?= Rudra::config()->get("url") ?>/$bundleUri/$table/search" method="post">
                    <div class="input-group">
                        <input class="form-control" type="text" name="search" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <?php CrudTable::drawTable("$table", "$bundleUri",\$fields, \$rows) ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-12 col-md-7">
                <?php if (count(\$links) > 1): ?>
                    <ul class="pagination">
                        <?php foreach (\$links as \$link): ?>
                            <li class="paginate_button page-item <?php if(\$link == \$page): ?> active <?php endif; ?>"><a href="<?= Rudra::config()->get("url") ?>/$bundleUri/$table/page/<?= \$link ?>" class="page-link"><?= \$link ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>
EOT;
    }

    public function createUiContent(array $names)
    {
        extract($names);

        return <<<EOT
<?php
    use App\\$bundleName\UI\CrudCreateForm;
?>
<main>
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">$table</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                $uTable CRUD:
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <?php CrudCreateForm::drawForm("$table", "$bundleUri", \$columns) ?>

                    <script>
                        CKEDITOR.replace( 'editor' );
                    </script>
                </div>
            </div>
        </div>
    </div>
</main>
EOT;
    }

    public function updateUiContent(array $names)
    {
        extract($names);

        return <<<EOT
<?php
    use App\\$bundleName\UI\CrudUpdateForm;
?>
<main>
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">$table</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                $uTable CRUD:
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <?php CrudUpdateForm::drawForm("$table", "$bundleUri", \$columns, \$item) ?>

                    <script>
                        CKEDITOR.replace( 'editor' );
                    </script>
                </div>
            </div>
        </div>
    </div>
</main>
EOT;
    }

    public function crudTable(string $bundleName)
    {
        return <<<EOT
<?php

namespace App\\$bundleName\UI;

use Rudra\Container\Facades\Rudra;

class CrudTable
{
    public static function drawTable(\$table, \$bundleUri, \$fields, \$rows)
    {?>
        <table class="table table-striped table-dark table-bordered" style="width:100%">
            <thead>
            <tr>
                <?php foreach (\$fields as \$field): ?>
                    <th><?= \$field ?></th>
                <?php endforeach; ?>
                <th class="text-center"><a href="<?= Rudra::config()->get("url") ?>/<?= \$bundleUri ?>/<?= \$table ?>/create"><button type="button" class="btn btn-info"><i class="far fa-plus-square"></i>Add new</button></a></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach (\$rows as \$row): ?>
                <tr>
                    <?php foreach (\$fields as \$field): ?>
                        <td class="align-middle"><?= \$row[\$field] ?></td>
                    <?php endforeach; ?>

                    <td class="align-middle text-center">

                        <a href="<?= Rudra::config()->get("url") ?>/<?= \$bundleUri ?>/<?= \$table ?>/update/<?= \$row["id"] ?>"><button type="button" class="btn btn-success"><i class="fas fa-edit"></i></button></a>
                        <a href="<?= Rudra::config()->get("url") ?>/<?= \$bundleUri ?>/<?= \$table ?>/delete/<?= \$row["id"] ?>"><button type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php
    }
}
EOT;
    }

    public function crudCreateForm(string $bundleName)
    {
        return <<<EOT
<?php

namespace App\\$bundleName\UI;

use Rudra\Container\Facades\Rudra;
use Rudra\Container\Facades\Session;

class CrudCreateForm
{
    public static function drawForm(\$table, \$bundleUri, \$columns)
    {?>
        <form id="form" action="<?= Rudra::config()->get("url") ?>/<?= \$bundleUri ?>/<?= \$table ?>/create" method="post">
        <input type='hidden' name='csrf_field' value='<?= Session::get('csrf_token')[0]; ?>'>
        <?php foreach (\$columns as \$column): ?>
        <?php if ((\$column->Field === "id") or (\$column->Field === "created_at") or (\$column->Field === "updated_at")) continue; ?>
        <?php if (\$column->Type === "text"): ?>
            <div class="form-group">
                <label for="editor" class="col-form-label"><?= \$column->Field ?>:</label>
                <textarea name="<?= \$column->Field ?>" class="form-control" id="editor"></textarea>
            </div>
        <?php else: ?>
            <div class="form-group">
                <label for="recipient" class="col-form-label"><?= \$column->Field ?>:</label>
                <input name="<?= \$column->Field ?>" type="text" class="form-control" id="recipient" value="">
            </div>
        <?php endif; ?>
        <?php endforeach; ?>
            <button type="submit" class="btn btn-primary" form="form">Save changes</button>
        </form>
        <?php
    }
}
EOT;
    }

    public function crudUpdateForm(string $bundleName)
    {
        return <<<EOT
<?php

namespace App\\$bundleName\UI;

use Rudra\Container\Facades\Rudra;
use Rudra\Container\Facades\Session;

class CrudUpdateForm
{
    public static function drawForm(\$table, \$bundleUri, \$columns, \$item)
    {?>
        <form id="form" action="<?= Rudra::config()->get("url") ?>/<?= \$bundleUri ?>/<?= \$table ?>/update" method="post">
        <input type='hidden' name='csrf_field' value='<?= Session::get('csrf_token')[0]; ?>'>
        <input type='hidden' name='id' value='<?= \$item->id ?>'>
        <?php foreach (\$columns as \$column): ?>
        <?php if ((\$column->Field === "id") or (\$column->Field === "updated_at")) continue; ?>
        <?php if (\$column->Type !== "text"): ?>
            <div class="form-group">
                <label for="recipient" class="col-form-label"><?= \$column->Field ?>:</label>
                <input name="<?= \$column->Field ?>" type="text" class="form-control" id="recipient" value="<?= \$item->{\$column->Field} ?>">
            </div>
        <?php endif; ?>

        <?php if (\$column->Type === "text"): ?>
            <div class="form-group">
            <?php if (strpos(\$item->{\$column->Field}, "script") !== false): ?>
                <label for="<?= \$column->Field ?>" class="col-form-label"><?= \$column->Field ?>:</label>
                <textarea name="<?= \$column->Field ?>" class="form-control" id="<?= \$column->Field ?>"><?= \$item->{\$column->Field} ?></textarea>
            <?php else: ?>
                <label for="editor" class="col-form-label"><?= \$column->Field ?>:</label>
                <textarea name="<?= \$column->Field ?>" class="form-control" id="editor"><?= \$item->{\$column->Field} ?></textarea>
            <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php endforeach; ?>
            <button type="submit" class="btn btn-primary" form="form">Save changes</button>
        </form>
        <?php
    }
}
EOT;
    }

    public function createLayout(string $bundleUri)
    {
        return <<<EOT
<?php
    use Rudra\Container\Facades\Session;
    use Rudra\Container\Facades\Rudra;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title><?= \$title ?></title>
        <link href="<?= Rudra::config()->get('url') ?>/assets/admin/css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="#"><i class="fas fa-bars"></i> RudraAdmin</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-arrows-alt-h"></i></button>
            <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0"></div>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" Data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">Settings</a>
                        <a class="dropdown-item" href="#">Activity Log</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?= Rudra::config()->get('url') ?>/logout">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="admin">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Interface</div>
                            <a class="nav-link collapsed" href="#" Data-toggle="collapse" Data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Layouts
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" Data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="layout-static.html">Static Navigation</a>
                                    <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" Data-toggle="collapse" Data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Pages
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" Data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" Data-toggle="collapse" Data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Authentication
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" Data-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="login.html">Login</a>
                                            <a class="nav-link" href="register.html">Register</a>
                                            <a class="nav-link" href="password.html">Forgot Password</a>
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" Data-toggle="collapse" Data-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        Error
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" Data-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="401.html">401 Page</a>
                                            <a class="nav-link" href="404.html">404 Page</a>
                                            <a class="nav-link" href="500.html">500 Page</a>
                                        </nav>
                                    </div>
                                </nav>
                            </div>
                            <div class="sb-sidenav-menu-heading">Addons</div>
                            <?php foreach (require_once Rudra::config()->get('app.path') . "/app/Data/cruds.php" as \$item): ?>

                            <a class="nav-link" href="<?= Rudra::config()->get('url') ?>/$bundleUri/<?= \$item ?>">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                <?= ucfirst(\$item) ?>
                            </a>

                            <?php endforeach ?>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?= Session::get("user")->email ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <?= \$content ?>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2020</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?= Rudra::config()->get('url') ?>/assets/admin/js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    </body>
</html>
EOT;
    }
}
