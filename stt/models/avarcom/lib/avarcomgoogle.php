<?
class AvarcomGoogle
{

    private $jsonFilePath = "";
    private $client;

    public function __construct()
    { 
        
        $this->jsonFilePath = $_SERVER["DOCUMENT_ROOT"] . "/stt/models/google/panel/ss.json";
        $GoogleModule = new GoogleModule();

        $googleAccountKeyFilePath = $this->jsonFilePath;
        putenv( 'GOOGLE_APPLICATION_CREDENTIALS=' .  $googleAccountKeyFilePath);

        $this->client = new Google\Client();

        $this->client->useApplicationDefaultCredentials();
        $this->client->addScope( 'https://www.googleapis.com/auth/webmasters' );

        $webmaster = new Google\Service\Webmasters($this->client);
    }

    public function getUrlInfo($url)
    {
        $this->client->addScope('https://www.googleapis.com/auth/indexing');
        $httpClient = $this->client->authorize();
        $endpoint = 'https://indexing.googleapis.com/v3/urlNotifications:publish';
        
        $response = $httpClient->get('https://indexing.googleapis.com/v3/urlNotifications/metadata?url=' . urlencode($url));
        $data = json_decode((string) $response->getBody(), true);
        return $data;
    }

    public function updateScanPage($url)
    {
        $type = "URL_UPDATED";
        $this->client->addScope('https://www.googleapis.com/auth/indexing');
        $httpClient = $this->client->authorize();
        $endpoint = 'https://indexing.googleapis.com/v3/urlNotifications:publish';
        $content = json_encode([
         'url' => $url,
         'type' => $type
       ]);
       $response = $httpClient->post($endpoint, ['body' => $content]);
       $data = (string) $response->getBody();

       return $data;
    }
} 