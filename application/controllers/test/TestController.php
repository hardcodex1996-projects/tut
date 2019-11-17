<?php


// application/controllers/admin/IndexController.class.php


class TestController extends BaseController
{
    private static $template_view = CURR_VIEW_PATH . "test.php";
    private static $Funcs;
    public function  __construct(){
        parent::__construct();
        $this->loader->helper('Funcs');
        self::$Funcs = new Funcs();
        echo "";
    }
    public function indexAction()
    {
        // Load View template
        include self::$template_view;
    }

}
