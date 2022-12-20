<?
class AutoLoaderModels{

    public $moduleName;
    private $arrLoaded;
    private $includedAutoloaderFiles;
    
    public function __construct($module){
        $this->moduleName = $module;
    }
    
    public function includeClass($arFields){
        foreach ($arFields as $dir => $arClass){
            foreach ($arClass as $class){
               $this->includeClassFile($dir, $class);
            } 
        } 
    }

    private function includeClassFile($dir, $class){
        if (isset($this->$arrLoaded[$this->moduleName][$dir])){
            $issetElement = false; 
            foreach ($this->$arrLoaded[$this->moduleName][$dir] as $object){
                if ($object == $class){
                    $issetElement = true;
                }
            }
            if (!$issetElement){
                $this->$arrLoaded[$this->moduleName][$dir][] = $class;
            }
        } else {
            $this->$arrLoaded[$this->moduleName][$dir][] = $class;
        }

        $className = $class;
        $fileName = '';
        $namespace = '';
        // Sets the include path as the "src" directory
        
        $includePath = $_SERVER["DOCUMENT_ROOT"]."/stt/models/".$this->moduleName.DIRECTORY_SEPARATOR.$dir;
      
        if (false !== ($lastNsPos = strripos($className, '\\'))) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
        $fullFileName = $includePath . DIRECTORY_SEPARATOR . $fileName;

        if (file_exists($fullFileName)) {
            require_once $fullFileName;
        } else {
            echo 'Class "'.$className.'" does not exist.<br>';
            echo $fullFileName;
        }
    }
    public function getLoadedArray(){
        return $this->$arrLoaded;
    }
}
?>