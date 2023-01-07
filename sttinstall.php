<?
$archiveUrl = "https://stt-corp.ru/pages/archive.zip";
$archiveName = "archive.zip";

/**
 * Функция скачивания удаленного файла на сервер
 * void curl_download(string $url, string $file)
 *
 * @param string url - путь к удаленному файлу
 * @param string file - путь к локальному файлу (в него записываем файл)
 *
 * @return void
 *
 */
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

curl_download($archiveUrl, $archiveName);

$pathdir = './'; // путь к папке, в которую будет распакован архив
$done = unzip_file($_SERVER["DOCUMENT_ROOT"] . '/' .$archiveName, $pathdir );
if( is_string($done) ){
	echo 'Ошибка: '. $done;
}