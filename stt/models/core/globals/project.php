<?
/**
 * Управляет над проектом
 */
    final class Project
    {

        public $includuModulesList = [];
        public $objects;
        public $projectStyles;
        public $projectJsScripts;
        public $title = "";
        public $keywords = "";
        public $description = "";

        private $objectsList;
        private $controllerObject; 
        public $sessionObject;

        public function __construct(){

        }   
        
        //Устанавливает объекты
        public function setObject($name, $object){
            $this->objects[$name] = $object;
        }   

        public function install(){
            $this->getInfoToProject();
        }

        //Устанавливает объект установки
        public function setInstallObject($object){
            $object->setDataBaseObject($this->objects["Core"]->DataBaseObject);
            $this->objects["Install"] = $object;   
        }

        private function getInfoToProject(){
            
            //Получаем список модулей
            $InstallModules = new InstallModules();
            $InstallModules->setDataBaseObject($this->objects["Core"]->DataBaseObject);
            $InstallModules->installModules();
      
        }


        public function installProject(){

        }

        private function installModels(){
            $this->getModeles();
        }
  
        //Подключает необходимые модули
        public static function includeModules($module_code){
            global $PROJECT;
            $fullName = $_SERVER["DOCUMENT_ROOT"] . "/stt/models/" . $module_code . "/" . $module_code . "module.php";
            if (file_exists($fullName)){
                $PROJECT->includuModulesList[$module_code] = $module_code;
                require_once $fullName;
            }
        }    

        //Подключает контроллеры проекта
        public function includeController($controller, $view = "", $params = []){
            if (!class_exists("ControllersModule")){
                self::includeModules("controllers");
                $this->controllerObject = new ControllersModule();
            } else {
                if (empty($this->controllerObject)){
                    $this->controllerObject = new ControllersModule();
                }
            }

            $this->controllerObject->executeController($controller, $view, $params);

            $this->includeControllersStyles($controller, $view);
            $this->includeControllerJsScripts($controller, $view);
        }

        public function includeControllersStyles($controller, $view){
            if ($this->controllerObject->includeControllerStyle($controller, $view)){
                $this->projectStyles[] = $this->controllerObject->includeControllerStyle($controller, $view);
            }
        }

        public function includeControllerJsScripts($controller, $view){
            if ($this->controllerObject->includeControllerJsScript($controller, $view)){
                $this->projectJsScripts[] = $this->controllerObject->includeControllerJsScript($controller, $view);
            }
        }

        public function setSessionObject($object){
            $this->sessionObject = $object;
        }

        public function setSessionValues($key, $value){
            $this->sessionObject->setSessionValues($key, $value);
        }
        public function removeSessionValue($key){
            $this->sessionObject->removeSessionValue($key);
        }
    } 
