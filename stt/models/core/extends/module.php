<?
abstract class Module{

    private $autoload;

    protected $moduleName;
    protected $moduleTitle = "";

    protected $arFields = [];
    protected static $class = __CLASS__;

    public function __construct()
    {   
        global $PROJECT; 
        $this->autoload = $PROJECT->objects["AutoLoad"];


        if (!empty($this->moduleName)){
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

    public function executeModule(){

    }

    public function getModuleName(){
        return $this->moduleName;
    }

    public function getModuleTitle(){
        return $this->moduleTitle;
    }

}
