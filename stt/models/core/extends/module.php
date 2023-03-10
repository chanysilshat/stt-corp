<?

abstract class Module{

    protected $autoload;
    protected $version = 1;
    protected $moduleName;
    protected $moduleTitle = "";
    protected $arFields = [];
    protected $controllersList = [];
    protected $moduleFilesList = [];
    protected $dependency = [];

    protected static $class = __CLASS__;

    public function __construct()
    {   
        global $PROJECT; 
        $this->autoload = $PROJECT->objects["AutoLoad"];

        if (!empty($this->moduleName)){
            $this->beforeExecuteModule();

            $this->autoload->moduleName = $this->moduleName;
            if (!empty($this->arFields)){
                $this->autoload->includeClass($this->arFields);
            }
            $this->executeModule();
        }

        if (empty($this->moduleTitle)){
            $this->moduleTitle = $this->moduleName;
        }
    } 

    public function beforeExecuteModule()
    {

    }

    public function executeModule()
    {

    }

    public function getModuleName()
    {
        return $this->moduleName;
    }

    public function getModuleTitle()
    {
        return $this->moduleTitle;
    }

    public function getControllersList()
    {
        return $this->controllersList;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getModuleFilesList()
    {
        return $this->moduleFilesList;
    }

}
