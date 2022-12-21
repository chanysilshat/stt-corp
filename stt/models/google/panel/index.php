

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once $_SERVER['DOCUMENT_ROOT'] . '/stt/models/google/vendor/autoload.php';

$data = [
  'result' => 'success'
];
 
$url = "https://avarcom702.stt-corp.ru/iglino/";
$action = "get1";
$type = $action == 'update' ? 'URL_UPDATED' : 'URL_DELETED';
/* 
if (!filter_var($url, FILTER_VALIDATE_URL)) {
  $data['result'] = 'error';
  $data['error'] = 'URL не является корректным.';
  echo json_encode($data);

}*/

$client = new Google_Client();
// api-project-696409.json - секретный ключ для доступа к API Google
//
//$client->setAuthConfig(__DIR__ . '/php/api-project-696409.json');
$json = file_get_contents(__DIR__ . '/php/api-project-696409.json');
$client->setAuthConfig(__DIR__ . '/php/api-project-696409.json');
$client->addScope('https://www.googleapis.com/auth/indexing');
$httpClient = $client->authorize();
$endpoint = 'https://indexing.googleapis.com/v3/urlNotifications:publish';
if ($action == 'get') {
  $response = $httpClient->get('https://indexing.googleapis.com/v3/urlNotifications/metadata?url=' . urlencode($url));
} else {
  $content = json_encode([
    'url' => $url,
    'type' => "URL_UPDATED"
  ]);
  $response = $httpClient->post($endpoint, ['body' => $content]);
}
$data['body'] = (string) $response->getBody();
echo "<pre>"; print_r($data); echo "</pre>";

echo json_encode($data);


/*$postBody = new Google_Service_Webmasters_SearchAnalyticsQueryRequest( [
    'startDate'  => '2019-01-01',
    'endDate'    => '2019-02-01',
    'dimensions' => [
         'query'
     ],
   'rowLimit' => 5
] );
$searchAnalyticsResponse = $serviceWebmasters->searchanalytics->query( $url, $postBody );
echo "<pre>"; print_r($searchAnalyticsResponse); echo "</pre>";
