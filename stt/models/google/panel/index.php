<?php
//https://searchconsole.googleapis.com/$discovery/rest?version=v1
$json = '{
    "type": "service_account",
    "project_id": "stt-project-372301",
    "private_key_id": "d3b20e9bd486f4611267370bc14d1077a1813ab2",
    "private_key": "-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQDlUXaoiFg/0xUc\n/lTbKJNCdE2UQ7dWbvfGJwUwPDrUMr6hWa5rg+Pzfdi26jETIcoaNYC0yOaXTtsT\nk7R7wHj06U/hbZzAUFqiptWe3lgLFAx1SdNo8d7mJ8t/ChqQ3ULtBHftlyPzuUHP\nbkddRCQ0cLop77t2WtctdqOlb/fZpy299tOaLhhMooCLRbyWqRWZSkGAS/68GiZh\nl63YGWljlp6+/DK/QvLB+bdeLf/lCir2Mgn5crB3lvZZfF2XsIIEhK80rUtwJsIF\n3cBvidJcp2cTIsl4TTS8LxkxvoEzLsZE57b0GC3P5DDDF/jiytDMeb7yq92g9Jcz\nfgBprfavAgMBAAECggEACmStgZVVMDNZ1VISBReeMP711l68hcgKv9B17XBu/b4W\nolgSGscqaWQOeR/WvVy+Y0voe1Xqdl7sq/YsuG0jrkn19/jqIVQJZfs0wS1BOHzr\nCAfVpplLwz4R4ySeMDgInmOhwdykFJnhYzLgb76bLqtE3/Cz6N9uIDff0kUBKtXR\nOvbPIr9QzqBZPi5dd5iag+SqYloYrkVBAqhlSmg5/RZbFMVyGR7nDBAYO/gT+5pQ\n0l9iWxJuhBo1XjfQarTbil2U2hzOC8W7NO+/eVNz3Gh2Ffe2suMYWLHzALpNfyyO\nPNbUdsn79PWsOa8LTBiWVHqhwLRzFXTYjCb5f8EjSQKBgQD1AlMN0f478ontpD61\nMswywti9kHEbxZHxxshOvOlLroj27Y42gcrCZ6D6FZ+FWpnnKQhZHq7AiEEfV4z3\nH8XN/++ubSVrIY0Z0iEdkPyJYByfW/oVfXRYcUYQsMs5FW8wityzXjYxhtqAI/Gj\nxHvd6JqGAtyii1GDFDN8MGFYdwKBgQDvmvIdv20MbFY+NE9uF+aHhfSXAi4SL/+O\n7WBTFTshjMqw+AEiYW0tUEJbYyB3NP5H7kZ1HSFQFOtOpA/w+iNo8FOIwapJE9B3\nAnNeO4uAjetykbpr7YXwARvtM6hf9RkoVtPsW0fElEJKOiZ7C69Pz4+ijiSFoqlc\nfBGsCh4ZiQKBgAc5+1MkB3ijLbhJqOPVTLqOjrAAq6VjDWvxLgVMgyENU9LcrN4k\ns+NKBTB7JMpdIr7zseBXDFZ3blxLS8gaMs5hpyMg6wKe6beCQCHMHfa7U/zLTLQH\nkD/vj158qHHVlQL8hYfw1m5diOJQrRbke7bO3ofnW7SboVrZZK9cCfL/AoGAa5M1\ngQWhACLj1anGv7cbWV1bIzFnXeMO6izJQoQVuEpt9mZim/0B94ZBRKaMvPid8c2Y\n9JvPiRTbUMN4JMkpfMPpvUy2F3k97zC6e2RgjacqPpYPDMXnjIny79xxjCOO1/2j\nyEpzPl8SJCFXhYcJftvBsUoAO798KnnJtWQVf4ECgYA/81dTatLgjXW0bWsE+Lk+\ncKPs2Gz5XHQ4ymCqAY0/950o7vdhvtoisCF7lL2eQkVVMBlmTGwhO8GGv632ywq4\nwp0ifvUrrxBbD3h/BhZDVqb+8bEAu9i1kIxzrJPbP8tRLZq8/Pvm9Xy/lhrqbCYA\nTAwD4DFkAJZsMDghHv8dow==\n-----END PRIVATE KEY-----\n",
    "client_email": "stt-corp@stt-project-372301.iam.gserviceaccount.com",
    "client_id": "104917037127717106035",
    "auth_uri": "https://accounts.google.com/o/oauth2/auth",
    "token_uri": "https://oauth2.googleapis.com/token",
    "auth_provider_x509_cert_url": "https://www.googleapis.com/oauth2/v1/certs",
    "client_x509_cert_url": "https://www.googleapis.com/robot/v1/metadata/x509/stt-corp%40stt-project-372301.iam.gserviceaccount.com"
  }
   ';

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/


require_once  $_SERVER["DOCUMENT_ROOT"] . '/stt/models/google/vendor/autoload.php';

$googleAccountKeyFilePath = $_SERVER["DOCUMENT_ROOT"] . "/stt/models/google/panel/ss.json";
putenv( 'GOOGLE_APPLICATION_CREDENTIALS=' .  $googleAccountKeyFilePath);

$client = new Google\Client();

$client->useApplicationDefaultCredentials();
$client->addScope( 'https://www.googleapis.com/auth/webmasters' );

$webmaster = new Google\Service\Webmasters($client);



// Получаем список сайтов, к которым есть доступ
//$listSites = $webmaster->sites->listSites();
//echo "<pre>"; print_r($listSites); echo "</pre>";

// Получаем информацию о сайте
//$site = $webmaster->sites->get('https://avarcom702.stt-corp.ru/');
//echo "<pre>"; print_r($site); echo "</pre>";
// Получаем список добавленных файлов Sitemap
//$listSitemaps = $webmaster->sitemaps->listSitemaps('https://avarcom702.stt-corp.ru/');

// Получаем информацию о файле sitemap
/*
$sitemap = $webmaster->sitemaps->get(
	'https://avarcom702.stt-corp.ru/', // Адрес сайта
	'https://avarcom702.stt-corp.ru/avar_sitemap.xml' // Путь до карты сайта
);*/






$postBody = new Google\Service\Webmasters\SearchAnalyticsQueryRequest( [
	'startDate'  => '2019-01-01',
	'endDate'    => '2022-12-30',
	'dimensions' => [
		'query',
		'device',
		'date',
    'page'
	],
	//'rowLimit' => 5,
	'startRow' => 0
] );
$searchAnalyticsResponse = $webmaster->searchanalytics->query( 'https://avarcom702.stt-corp.ru/', $postBody );

 echo "<pre>"; print_r($searchAnalyticsResponse); echo "</pre>";




//Отправляем на обновление страницу
 /*$url = "https://avarcom702.stt-corp.ru/";
 $type = "URL_UPDATED";
 $client->addScope('https://www.googleapis.com/auth/indexing');
 $httpClient = $client->authorize();
 $endpoint = 'https://indexing.googleapis.com/v3/urlNotifications:publish';
 $content = json_encode([
  'url' => $url,
  'type' => $type
]);
$response = $httpClient->post($endpoint, ['body' => $content]);
$data['body'] = (string) $response->getBody();
echo "<pre>"; print_r($data); echo "</pre>";*/

/*$url = "https://avarcom702.stt-corp.ru/yanayl/";
$client->addScope('https://www.googleapis.com/auth/indexing');
$httpClient = $client->authorize();
$endpoint = 'https://indexing.googleapis.com/v3/urlNotifications:publish';

$response = $httpClient->get('https://indexing.googleapis.com/v3/urlNotifications/metadata?url=' . urlencode($url));
$data = json_decode((string) $response->getBody());

echo "<pre>"; print_r($data); echo "</pre>";*/