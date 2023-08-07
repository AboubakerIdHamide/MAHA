<?php

use App\Libraries\Response;
use App\Models\Stocked;

session_start();

// Composer autoload => composer dumpautoload
require_once '../vendor/autoload.php';

// Global Constants
require_once '../app/Config/globalConstants.php';

// Require all helpers
require_once '../App/helpers/redirect.php';
require_once '../App/helpers/view.php';
require_once '../App/helpers/flash.php';
require_once '../App/helpers/old.php';
require_once '../App/helpers/print_r2.php';
require_once '../App/helpers/date.php';


/*
 * Router File
 * URL FORMAT (Controller) - controller/method/params
 * URL FORMAT (ApiController) - api/controller/method/params
 */

class Router
{
    protected $currentController = "HomeController";
    protected $currentMethod = "index";
    protected $currentParams = [];

    public function __construct()
    {
        // Get URL
        $url = $this->getUrl();
        // Default
        if (!isset($url[0])) {
            require '../app/Controllers/' . $this->currentController . '.php';
            // initialize a contoller object
            $this->currentController = new $this->currentController;
            // getParams
            $this->currentParams = $url ? array_values($url) : [];

            // call callback with the params
            call_user_func_array([$this->currentController, $this->currentMethod], $this->currentParams);
            return;
        }

        if ($url[0] === 'api') {
            if (!isset($url[1])) {
                Response::json(null, 404, "404 Route Not Found");
            }
            $this->isApiControllerExist($url[1]);
            require '../app/Controllers/api/' . $this->currentController . '.php';
            // initialize a contoller object
            $this->currentController = new $this->currentController;
        } else {
            $this->isControllerExist($url[0]);
            require '../app/Controllers/' . $this->currentController . '.php';
            // initialize a contoller object
            $this->currentController = new $this->currentController;
            if (isset($url[1])) {
                if(!$this->isMethodExist($url[1])){
                    if(!$this->isMethodExist('index')){
                        if ($this->getUrl()[0] !== "api") {
                            require_once "../app/Views/errors/page_404.php";
                        } else {
                            Response::json(null, 404, "404 Route Not Found");
                        }
                        exit;
                    }
                }else{
                    unset($url[1]);
                }
            }

            // to keep only params
            unset($url[0]);

            // getParams
            $this->currentParams = $url ? array_values($url) : [];

            if($this->checkVisibility() === 'private'){
                require_once "../app/Views/errors/page_404.php";
                exit;
            }

            // call callback with the params
            call_user_func_array([$this->currentController, $this->currentMethod], $this->currentParams);
        }
    }

    private function checkVisibility()
    {
        $reflectionMethod = new \ReflectionMethod($this->currentController, $this->currentMethod);
        $visibility = \Reflection::getModifierNames($reflectionMethod->getModifiers());
        return $visibility[0];
    }

    private function isControllerExist($controllerName)
    {
        if (file_exists("../app/Controllers/" . ucwords($controllerName) . "Controller.php")) {
            $this->currentController = ucwords($controllerName) . 'Controller';
            return true;
        }
        $stocked = new Stocked;
        $themeData = $stocked->getThemeData();
        $theme["logo"] = URLROOT . "/Public/" . $themeData->logo;
        $theme["landingImg"] = URLROOT . "/Public/" . $themeData->landingImg;
        $data['theme'] = $theme;
        require_once "../app/Views/errors/page_404.php";
        exit;
    }

    private function isApiControllerExist($controllerName)
    {
        $controllerName = ucwords(substr($controllerName, 0, -1));
        if (file_exists("../app/Controllers/api/" . $controllerName . "Controller.php")) {
            $this->currentController = $controllerName . 'Controller';
            return true;
        }
        Response::json(null, 404, "404 Route Not Found");
        exit;
    }

    private function isMethodExist($methodName)
    {
        if (method_exists($this->currentController, $methodName)) {
            $this->currentMethod = $methodName;
            return true;
        }
        return false;
    }

    private function getUrl()
    {
        if (isset($_GET["url"])) {
            $url = rtrim($_GET["url"], "/");
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode("/", $url);
            return $url;
        }
    }
}

$init = new Router;
