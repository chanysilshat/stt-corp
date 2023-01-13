<?
class AvarcomManageController extends Controller
{
    public $arParams = [];
    protected $arData = [];
    public $url = "https://avarcom702.stt-corp.ru/";
    public $siteMap = "https://avarcom702.stt-corp.ru/avar_sitemap.xml";
    public $urlList = [];

    private $jsonDirPage;
    private $AvarcomGoogle;

    public function executeController()
    {
        $this->jsonDirPage = $_SERVER["DOCUMENT_ROOT"] . "/stt/models/avarcom/json/";

        global $PROJECT;
        $PROJECT::includeModules("avarcom");

        $AvarcomModule = new AvarcomModule();
        $PROJECT::includeModules("google");
        $this->AvarcomGoogle = new AvarcomGoogle();

        if (isset($_REQUEST["handler"]) && $_REQUEST["handler"] == "update"){
            $this->updateScan($_REQUEST["url"]);
        }

        if (isset($_REQUEST["xml"]) && isset($_REQUEST["sitemap"])){
            $this->createSiteMap();
        }
    
        $table = "avarcom_pages";

        $fileName = $this->jsonDirPage . "googlepages/ufa.json";

        $this->urlList[] = [
            "url" => $this->url,
        ];
        $res = $PROJECT->objects["TABLES"]->getList($table, ["city_code"], []);

        foreach ($res as $result){

            $url = $this->url . $result["city_code"] . DIRECTORY_SEPARATOR;
            
            $this->urlList[] = [
                "url" => $url,
            ];   
        }

        foreach ($this->urlList as $urlData){

            if (isset($_REQUEST["handler"]) && $_REQUEST["handler"] == "update-all"){
                $this->updateScan($urlData["url"]);
            }

            $fileName = $this->jsonDirPage . "googlepages/" . $this->getUrlFile($urlData["url"]) . ".json";

            $this->arData["urlList"][] = [
                "url" => $urlData["url"],
                "data" => json_decode(file_get_contents($fileName), true)
            ];
        }

       

        $this->includeControllerView();
    } 

    private function getUrlFile($url)
    {
        $url = str_replace("https://", "", $url);
        $url = str_replace("http://", "", $url);
        $url = str_replace("/", "", $url);
        $url = str_replace(".", "", $url);

        return $url;
    }

    private function updateScan($url)
    {
        $fileName = $this->jsonDirPage . "googlepages/" . $this->getUrlFile($url) . ".json";

        $data = json_decode($this->AvarcomGoogle->updateScanPage($url), true);
        file_put_contents($fileName, json_encode($data));
    }

    private function createSiteMap()
    {

        global $PROJECT;

        $table = "avarcom_pages";
        $res = $PROJECT->objects["TABLES"]->getTableArray($table, [], []);

            
        $dom = new DOMDocument('1.0', 'utf-8');
        $urlset = $dom->createElement('urlset');
        $urlset->setAttribute('xmlns','http://www.sitemaps.org/schemas/sitemap/0.9');

        // Создаём дочерний элемент
        $res["data"][] = [
            "city_code" => ""
        ];
        foreach ($res["data"] as $data){
            $url = $dom->createElement('url');

            $loc = $dom->createElement('loc');
            if (!empty($data["city_code"])){
                $text = $dom->createTextNode(
                    htmlentities('https://' . $_SERVER["HTTP_HOST"]. '/' . $data['city_code'] . '/', ENT_QUOTES)
                );
            } else {
                $text = $dom->createTextNode(
                    htmlentities('https://' . $_SERVER["HTTP_HOST"]. '/', ENT_QUOTES)
                );
            }
	        
            $loc->appendChild($text);
            $url->appendChild($loc);
        
            // Элемент <lastmod> - дата последнего изменения статьи.
            $lastmod = $dom->createElement('lastmod');
            $text = $dom->createTextNode(date('c'));
            $lastmod->appendChild($text);
            $url->appendChild($lastmod);
        
            // Элемент <priority> - приоритетность (от 0 до 1.0, по умолчанию 0.5).
            // Если дата публикации/изменения статьи была меньше недели назад ставим приоритет 1.
            $priority = $dom->createElement('priority');
            $text = $dom->createTextNode(1);
            $priority->appendChild($text);
            $url->appendChild($priority);
        
            $urlset->appendChild($url);

        }
        
        $dom->formatOutput = true;

        $dom->appendChild($urlset);

        $dom->save($_SERVER["DOCUMENT_ROOT"] . '/avar_sitemap.xml');
    }
} 