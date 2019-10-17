<?php

/**
 * Class Framework
 * Now under framework/core folder, we’ll create the framework’s first class - Framework.class.php in framework/core folder
 * we created a static function called run(). Now test it in index.php:
 * Normally this static function is called run() or bootstrap(). Within this function,
 * we can do 3 main things here, as shown in the code below:
 */
class Framework
{
    public static function run() {

        self::init();

        self::autoload();

        self::dispatch();

    }


    /**
     * Initialization of need variables.s
     */
    private static function init() {

        // Define path constants

        define("DS", DIRECTORY_SEPARATOR);

        define("ROOT", getcwd() . DS);

        define("APP_PATH", ROOT . 'application' . DS);

        define("FRAMEWORK_PATH", ROOT . "framework" . DS);

        define("PUBLIC_PATH", ROOT . "public" . DS);


        define("CONFIG_PATH", APP_PATH . "config" . DS);

        define("CONTROLLER_PATH", APP_PATH . "controllers" . DS);

        define("MODEL_PATH", APP_PATH . "models" . DS);

        define("VIEW_PATH", APP_PATH . "views" . DS);


        define("CORE_PATH", FRAMEWORK_PATH . "core" . DS);

        define('DB_PATH', FRAMEWORK_PATH . "database" . DS);

        define("LIB_PATH", FRAMEWORK_PATH . "libraries" . DS);

        define("HELPER_PATH", FRAMEWORK_PATH . "helpers" . DS);

        define("UPLOAD_PATH", PUBLIC_PATH . "uploads" . DS);


        // Define platform, controller, action, for example:

        // index.php?p=admin&c=Goods&a=add

        define("PLATFORM", isset($_REQUEST['p']) ? $_REQUEST['p'] : 'home');

        define("CONTROLLER", isset($_REQUEST['c']) ? $_REQUEST['c'] : 'Index');

        define("ACTION", isset($_REQUEST['a']) ? $_REQUEST['a'] : 'index');


        define("CURR_CONTROLLER_PATH", CONTROLLER_PATH . PLATFORM . DS);

        define("CURR_VIEW_PATH", VIEW_PATH . PLATFORM . DS);


        // Load core classes

        require CORE_PATH . "Controller.php";

        require CORE_PATH . "Loader.php";

        require DB_PATH . "Mysql.php";

        require CORE_PATH . "Model.php";


        // Load configuration file
        include CONFIG_PATH . "config.php";
        $GLOBALS['config'] = $config;



        // Start session
        session_start();

    }

    /**
     * We don’t want to manually code include or require for a class file what we
     * need in every script in the project, that’s why PHP MVC frameworks have this autoloading feature.
     * For example, in Symfony, if you put your own class file under ‘lib’ folder, then it will be auto loaded.
     * Magic? No, there is no magic. Let’s implement our autoloading feature in our mini framework.
     *Here we need to use a PHP built-in function called spl_autoload_register
     */
    private static function autoload(){
        spl_autoload_register(array(__CLASS__,'load'));
    }


    /**
     * @param $classname
     * custom load a class.
     * Every framework has a name conversion, ours is no exception.
     * For a controller class, it should be xxxController.class.php, for a model class,
     * it should be xxxModel.class.php. Why for a new framework you come across,
     * you must follow its naming convention? Autoloading is one of the reasons.
     */
    private static function load($classname){
        // Here simply autoload app’s controller and model classes
        if (substr($classname, -10) == "Controller"){
            // Controller
            require_once CURR_CONTROLLER_PATH . "$classname.php";
        } elseif (substr($classname, -5) == "Model"){
            // Model
            require_once  MODEL_PATH . "$classname.php";
        }
    }


    /**
     * Routing and dispatching.
     * In this step, index.php will dispatch the request to the proper Controller::Action() method.
     * It’s very simple here just for an example.
     */
    private static function dispatch(){

        // Instantiate the controller class and call its action method
        $controller_name = CONTROLLER . "Controller";

        $action_name = ACTION . "Action";

        $controller = new $controller_name;

        $controller->$action_name();

    }
}