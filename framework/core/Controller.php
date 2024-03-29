<?php
/**
 * There is always a base controller class(or several) in the framework’s core classes.
 * For example, In Symfony it’s called sfActions; in iOS it’s called UIViewController.
 * Here we will just name it Controller, the file name is Controller.class.php
 */


// Base Controller

class BaseController
{

    // Base Controller has a property called $loader, it is an instance of Loader class(introduced later)

    protected $loader;

    public function __construct()
    {

        $this->loader = new Loader();

    }


    public function redirect($url, $message, $wait = 0)
    {

        if ($wait == 0) {

            header("Location:$url");

        } else {

            include CURR_VIEW_PATH . "message.html";

        }


        exit;

    }

}