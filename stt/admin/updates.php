<?

$archiveUrl = $_SERVER["HTTP_HOST"];
$archiveName = "sttupdate.php";

function curl_download($url, $file)
{
	// открываем файл, на сервере, на запись
	$dest_file = @fopen($file, "w");
	
	// открываем cURL-сессию
	$resource = curl_init();
	
	// устанавливаем опцию удаленного файла
	curl_setopt($resource, CURLOPT_URL, $url);
	
	// устанавливаем место на сервере, куда будет скопирован удаленной файл
	curl_setopt($resource, CURLOPT_FILE, $dest_file);
	
	// заголовки нам не нужны
	curl_setopt($resource, CURLOPT_HEADER, 0);
	
	// выполняем операцию
	curl_exec($resource);
	
	// закрываем cURL-сессию
	curl_close($resource);
	
	// закрываем файл
	fclose($dest_file);
}

function unzip_file( $file_path, $dest ){
	$zip = new ZipArchive;

	if( ! is_dir($dest) ) return 'Нет папки, куда распаковывать...';

	// открываем архив
	if( true === $zip->open($file_path) ) {

		 $zip->extractTo( $dest );

		 $zip->close();

		 return true;
	}
	else
		return 'Произошла ошибка при распаковке архива';
}



    $PROJECT::includeModules("updates");

    $UpdateRest = new UpdateRest();


    $dir = opendir($_SERVER["DOCUMENT_ROOT"] . '/stt/models/');

    $modelsList = [];

    while($models = readdir($dir)){

        if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/stt/models/'.$models.'/' . $models . "module.php") && $models != '.' && $models != '..' && $models != 'stt') {
            $PROJECT::includeModules($models);
            $arModels[$models] = [];

            $modelsList[$models] = [
                "module_name" => $PROJECT->includeModulesList[$models]->getModuleName(),
                "module_title" => $PROJECT->includeModulesList[$models]->getModuleTitle(),
                "module_version" => $PROJECT->includeModulesList[$models]->getVersion(),
                "module_controllers" => $PROJECT->includeModulesList[$models]->getControllersList(),
                "module_files" => $PROJECT->includeModulesList[$models]->getModuleFilesList(),
            ];
            $data["data"]["modules.list"][$models] = $PROJECT->includeModulesList[$models]->getVersion();
        }
    }
    
    $result = $UpdateRest->executeMethod("get.modules.info", $data);
    
    if (isset($_REQUEST["handler"]) && $_REQUEST["handler"] == "update-system"){
        $fileName = "ss.php";
        $filePath = $_SERVER["DOCUMENT_ROOT"] . "/" . $fileName;
        $data = $result;
        file_put_contents($filePath, $UpdateRest->executeMethod("get.text.update.file", $data));

        $url = $archiveUrl . "/" . $fileName;
        echo $url;
        $Cnct = curl_init(); // инициализация cURL подключения
        curl_setopt($Cnct, CURLOPT_URL, $url); // адрес запроса

        if ($data){

            curl_setopt($Cnct, CURLOPT_POST, true);
            curl_setopt($Cnct, CURLOPT_POSTFIELDS, http_build_query($data));
        }
        
        curl_setopt($Cnct, CURLOPT_RETURNTRANSFER, 1); // просим вернуть результат
        $response = curl_exec($Cnct); 
        curl_close($Cnct);
        echo $response;
    }

?>
<form method="post">
    <input type="hidden" name="handler" value="update-system">
    <input type="submit" value="Обновить систему">
</form>