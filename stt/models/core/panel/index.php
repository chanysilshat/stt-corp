 <?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dir = $_SERVER["DOCUMENT_ROOT"];

$ss = "/home/c/cq15313/public_html/stt/models/core/extends/structuresystem.php";

$StructureSystem = new StructureSystem();
$StructureSystem->setDir("/");
$files = $StructureSystem->getFilesList();
$StructureSystem->createZipArchive(1);
echo 22;
file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/sys_files.txt", print_r($files, true));
/*
$zip = new ZipArchive();
$filename = "stt/initialization.php";

 
$zip->open($_SERVER["DOCUMENT_ROOT"]."/pages/archive.zip", ZIPARCHIVE::CREATE); //Открываем (создаём) архив archive.zip
$zip->addFromString('dir/test.txt', 'здесь следует содержимое файла');
$zip->addFile("index.php"); //Добавляем в архив файл index.php
$zip->addFile($filename); //Добавляем в архив файл styles/style.css
$zip->close(); //Завершаем работу с архивом 


$za = new ZipArchive();
$za->open($_SERVER["DOCUMENT_ROOT"].'/pages/archive.zip');

$i = 0;
$list = array();
while($name = $za->getNameIndex($i)) {
	$list[$i] = $name;
	$i++;
}

echo "<pre>"; print_r($list); echo "</pre>";
$za->close(); //Завершаем работу с архивом

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