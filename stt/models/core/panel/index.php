 <?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dir = $_SERVER["DOCUMENT_ROOT"];

$ss = "/home/c/cq15313/public_html/stt/models/core/extends/structuresystem.php";

$StructureSystem = new StructureSystem();
$StructureSystem->setDir("");
$files = $StructureSystem->getFilesList();
echo 22;
file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/sys_files.txt", print_r($files, true));
//echo "<pre>"; print_r($files); echo "</pre>";
//echo "<pre>"; print_r($StructureSystem->files); echo "</pre>";
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$path = $_SERVER["DOCUMENT_ROOT"];
$arFiles = getDirStructure($path, ""); 

echo "<pre>"; print_r($arFiles); echo "<pre>";

function getDirStructure($path = "", $dirName = "/"){
    
    echo "<pre>"; print_r($path); echo "</pre>";

    $arStructure[$dirName] = [];

    $dir = opendir($path);

    while ($objects = readdir($dir)) {

        if ($objects != '.' && $objects != '..'){
            
            $ob = $path . "/" . $objects;
            if (is_dir($ob)){
                $arStructure[$dirName]["DIR"][$objects] = getDirStructure($path . "/" . $objects, $objects);
            }
           
        }
    }


    return $arStructure[$dirName];
}
*/