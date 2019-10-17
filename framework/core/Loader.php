<?php

/**
 * Class Loader
 * In framework.class.php, we have already implemented application’s controller and model class’ autoloading.
 * But how to load classes in the framework directory? Here we can create a new class called Loader,
 * it will be used to load the framework’s classes and functions. When we need to load a framework’s class,
 * just call this Loader class’s method.
 */
class Loader{

    // Load library classes

    public function library($lib){

        include LIB_PATH . "$lib.php";

    }


    // loader helper functions. Naming conversion is xxx_helper.php;

    public function helper($helper){

        include HELPER_PATH . "{$helper}_helper.php";

    }

}