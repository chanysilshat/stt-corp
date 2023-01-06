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

    public function createZipArchive($zipName)
    {

        $zipFullFilePath = $_SERVER["DOCUMENT_ROOT"]."/pages/archive.zip";

        if (file_exists($zipFullFilePath)){
            unlink($zipFullFilePath);
        }

        $zip = new ZipArchive();

        $zip->open($zipFullFilePath, ZIPARCHIVE::CREATE); //Открываем (создаём) архив archive.zip

        foreach ($this->dirStructure as $key => $structure){
            $zipFilePath = str_replace($_SERVER["DOCUMENT_ROOT"] . $this->dir . DIRECTORY_SEPARATOR, "", $key);

            foreach ($structure as $fileName){
                if (file_exists($zipFilePath . $fileName)){
                    $zip->addFromString($zipFilePath . $fileName, file_get_contents($key . $fileName));
                }
            }

        }


        $zip->close(); //Завершаем работу с архивом 
    }
}