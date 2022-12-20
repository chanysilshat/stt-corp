<?
final class ControllersModule extends Module
{

    protected $moduleName = "controllers";
    protected $controllersList = [];
    protected $controllersPath = [];
    protected $controllersObject = [];

    protected $arFields = [
        "extends" => [
            "controller"
        ]
    ];

    public function executeModule(){

        $dir = opendir($_SERVER["DOCUMENT_ROOT"] . '/stt/controllers/');

        while($controller = readdir($dir)) {

            if (is_dir('stt/controllers/'.$controller) && $controller != '.' && $controller != '..') {
                $fullFileName =  $_SERVER["DOCUMENT_ROOT"] . '/stt/controllers/' . $controller . '/controller.php';
                if (file_exists($fullFileName)){

                    $this->controllersPath[$controller] = $fullFileName;

                    require_once $fullFileName;
                }
                
            }
        }
        
        foreach( get_declared_classes() as $class ){
            if(is_subclass_of( $class, 'Controller') ){
                $children[] = $class; 
                $path = (new \ReflectionClass($class))->getFileName();
                foreach ($this->controllersPath as $controller => $controllerPath){
                    if ($controllerPath == $path){
                        $this->controllersList[$controller] = $class;
                    }
                }
            }
        }

        foreach ($this->controllersList as $key => $controller){
            $this->controllersObject[$key] = new $controller();
        }
         
    }

    public function executeController($controller, $view = "", $params = []){

        if (isset($this->controllersObject[$controller])){

            $this->controllersObject[$controller]->setControllerParams($params);
            $fullDirName = $_SERVER["DOCUMENT_ROOT"] . "/stt/views/controllers/" . $controller . "/" . $view . "/";

            if (is_dir($fullDirName)){
                $this->controllersObject[$controller]->setControllerView($fullDirName);
            }
            $this->controllersObject[$controller]->executeController();

           

        }
    }

    public function includeControllerStyle($controller, $view){
        if (isset($this->controllersObject[$controller])){
            $fullFileName = $_SERVER["DOCUMENT_ROOT"] . "/stt/views/controllers/" . $controller . "/" . $view . "/style.css"; 
            if (file_exists($fullFileName)){
                $fileName = "/stt/views/controllers/" . $controller . "/" . $view . "/style.css"; 
                return $fileName;
            } else {
                return false;
            }
        }
    }

    public function includeControllerJsScript($controller, $view){
        if (isset($this->controllersObject[$controller])){
            $fullFileName = $_SERVER["DOCUMENT_ROOT"] . "/stt/views/controllers/" . $controller . "/" . $view . "/script.js"; 
            if (file_exists($fullFileName)){
                $fileName = "/stt/views/controllers/" . $controller . "/" . $view . "/script.js"; 
                return $fileName;
            } else {
                return false;
            }
        }
    }
}