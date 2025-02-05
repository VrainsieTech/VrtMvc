<?php

namespace Vrainsietech\Vrtmvc\Helpers;

class FileGenerator
{
    public static function createController(string $controllerName): void
    {
        $controllerPath = __DIR__ . '/../../src/Controllers/' . $controllerName . '.php';

        if (file_exists($controllerPath)) {
            echo "Controller '$controllerName' already exists.\n";
            return;
        }

        $controllerContent = <<<EOT
<?php

namespace Vrainsietech\Vrtmvc\Controllers;

use Vrainsietech\Vrtmvc\Http\Request;
use Vrainsietech\Vrtmvc\Http\Response;

class $controllerName
{
    public function index(Request \$request)
    {
        return new Response("Hello from {$controllerName}!");
    }
}
EOT;

        file_put_contents($controllerPath, $controllerContent);
        echo "Controller '$controllerName' created successfully.\n";
    }

    public static function createView(string $viewName): void
    {
        $viewPath = __DIR__ . '/../../Views/' . $viewName . '.php';

        if (file_exists($viewPath)) {
            echo "View '$viewName' already exists.\n";
            return;
        }

        $viewContent = <<<EOT
<?php

include "header.php"

?>

<section>
  <div class="flexer flxcenter">
  <div class="btn-primary text-center">Hi, I am a div in the center at the top of this file.
   I am in View $viewName.</div>
  </div>
</section>

<?php include "footer.php";?>
EOT;

        file_put_contents($viewPath, $viewContent);
        echo "View '$viewName' created successfully.\n";
    }
}