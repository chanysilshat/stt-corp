<?
class StructureSystem
{
    private $system_path;
    private $dir;
    private $dirFiles;
    private $dirCatalogs;
    public $dirStructure;
    public $files;


    public function __construct()
    {
        $this->system_path = $_SERVER["DOCUMENT_ROOT"];
    }

    public function setDir($dir = "/")
    {
        $this->dir = $dir;
    }

    public function getDirFiles()
    {

        $path = $this->system_path . DIRECTORY_SEPARATOR . $dirName;
        $dir = opendir($path);
        while ($object = readdir($dir)) {

            if ($object != '.' && $object != '..'){
                if (is_file($object)){
                    $this->dirFiles[] = $object;
                }
            }
        }

        return $this->dirFiles;
    }

    public function getDirCatalogs()
    {

        $path = $this->system_path . DIRECTORY_SEPARATOR . $dirName;
        $dir = opendir($path);
        while ($object = readdir($dir)) {

            if ($object != '.' && $object != '..'){
                if (is_dir($object)){
                    $this->dirCatalogs[] = $object;
                }
            }
        }

        return $this->dirCatalogs;
    }

    public function searchFiles()
    {

    }

    public function getCatalogsList()
    {

    }

    public function getFilesList()
    {
        $fullDirPath = $this->system_path . $this->dir . DIRECTORY_SEPARATOR;
        self::getDirs($fullDirPath, $this);
        $this->getDirStructureFiles();
        return $this->dirStructure;
    }

    private static function getDirs($fullPath, $StructureSystem)
    {
        $StructureSystem->dirStructure[$fullPath] = [];
        
        $dir = opendir($fullPath);

        while ($object = readdir($dir)){
            if ($object != '.' && $object != '..'){
                if (is_dir($fullPath . $object . DIRECTORY_SEPARATOR)){
                    $StructureSystem->dirStructure[$fullPath . $object . DIRECTORY_SEPARATOR] = [];
                    self::getDirs($fullPath . $object . DIRECTORY_SEPARATOR, $StructureSystem);
                }
            }
        }
    }

    private function getDirStructureFiles()
    { 
        foreach ($this->dirStructure as $path => $array){
            $dir = opendir($path);
            while ($object = readdir($dir)){
                try {

                    if ($object != '.' && $object != '..'){
                        if (is_file($path . $object)){
                            //$this->files[] = $object;
                            $this->dirStructure[$path][] = $object;
                        }
                    }
                }   catch (Exception $e) {

                    echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
                  
                }
            }
        }
    }

}