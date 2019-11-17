<?php


// application/controllers/admin/IndexController.class.php


class AjaxController extends BaseController
{
    private static $template_view = CURR_VIEW_PATH . "";
    private static $Funcs;

    private static $response;

    public function  __construct(){
        parent::__construct();
        $this->loader->helper('Funcs');
        self::$Funcs = new Funcs();
    }
    public function indexAction()
    {
       echo "it works.";
    }
    public function get_forecast_plansAction(){
        $plans = self::$Funcs->get_data('forecast_plans.json');
        header("Content-Type: application/json;charset=utf-8");
        echo self::$response = $plans;

    }

}
