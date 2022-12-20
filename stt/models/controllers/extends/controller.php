<?
abstract class Controller{

    public $arParams = [];

    protected $arData = [];
    protected $viewPath = "";

    public function executeController(){

    }

    public function setControllerParams($params = []){
        $this->arParams = $params;
    }
    public function setControllerView($path){
        $this->viewPath = $path;
    }
    public function includeControllerView($view = "view"){
        if (!empty($this->viewPath)){
            $fullFileName = $this->viewPath . $view . ".php";
            if (file_exists($fullFileName)){
                $arData = $this->arData;
                $arParams = $this->arParams;
                require $fullFileName;
            }

        }
    }
} 