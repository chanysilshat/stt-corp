<?
class AvarcomManageController extends Controller
{
    public $arParams = [];
    protected $arData = [];

    public function executeController()
    {
        if (isset($_REQUEST["xml"]) && isset($_REQUEST["sitemap"])){
            $this->createSiteMap();
        }

        global $PROJECT;

        $this->includeControllerView();
    } 

    private function createSiteMap(){

        global $PROJECT;

        $table = "avarcom_pages";
        $res = $PROJECT->objects["TABLES"]->getTableArray($table, [], []);

            
        $dom = new DOMDocument('1.0', 'utf-8');
        $urlset = $dom->createElement('urlset');
        $urlset->setAttribute('xmlns','http://www.sitemaps.org/schemas/sitemap/0.9');

        // Создаём дочерний элемент
        foreach ($res["data"] as $data){
            $url = $dom->createElement('url');

            $loc = $dom->createElement('loc');
	        $text = $dom->createTextNode(
                htmlentities('https://' . $_SERVER["HTTP_HOST"]. '/' . $data['city_code'] . '/', ENT_QUOTES)
            );
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