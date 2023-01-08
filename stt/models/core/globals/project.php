<?
/**
 * Управляет над проектом
 */
    final class Project
    {

        public $includeModulesList = [];
        public $includeModulesPath = [];
        public $objects;
        public $projectStyles;
        public $projectJsScripts;
        public $title = "";
        public $keywords = "";
        public $description = "";
        public $canonical = "";
        public $sessionObject;

        private $objectsList;
        private $controllerObject; 
        private $configObject;

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

            if (!isset($PROJECT->includeModulesList[$module_code])){
                $fullName = $_SERVER["DOCUMENT_ROOT"] . "/stt/models/" . $module_code . "/" . $module_code . "module.php";
                
                if (file_exists($fullName)){
                    require_once $fullName;
    
                    foreach( get_declared_classes() as $class ){
                        if(is_subclass_of( $class, 'Module') ){
                            $children[] = $class; 
                            $path = (new \ReflectionClass($class))->getFileName();
                            $PROJECT->includeModulesPath[$path] = $class;
                        } 
                    }
    
                    
                    if (isset($PROJECT->includeModulesPath[$fullName])){
                        $mod = new $PROJECT->includeModulesPath[$fullName]();
                        $PROJECT->includeModulesList[$module_code] = $mod;
                    }
    
                }
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

        public function includeControllerJsScripts($controller, $view)
        {
            if ($this->controllerObject->includeControllerJsScript($controller, $view)){
                $this->projectJsScripts[] = $this->controllerObject->includeControllerJsScript($controller, $view);
            }
        }

        public function setSessionObject($object)
        {
            $this->sessionObject = $object;
        }

        public function setSessionValues($key, $value)
        {
            $this->sessionObject->setSessionValues($key, $value);
        }

        public function removeSessionValue($key)
        {
            $this->sessionObject->removeSessionValue($key);
        }

        public function setConfigObject($configObject)
        {
            $this->configObject = $configObject;
        }

        public function getConfigValue($config, $module)
        {
            return $this->configObject->getConfigValue($config, $module);
        }
    } 
