<form method="get">
    <input type="hidden" name="xml" value="1">
    <input type="hidden" name="sitemap" value="avar_sitemap">
    <input type="submit" value="Сгенерировать Sitemap">
</form>

<?
    $PROJECT->includeController(
        "avarcom-statistics", 
        "statistics",
        [
        ]
    );
    
?>

<div>

</div>

<?
    global $PROJECT;
    $PROJECT::includeModules("avarcom");
    $AvarcomModule = new AvarcomModule();
    $AvarStatistics = new AvarStatistics();

    if (isset($_REQUEST["xml"]) && isset($_REQUEST["sitemap"])){

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


           
        /*
        $xw = xmlwriter_open_memory();
        xmlwriter_set_indent($xw, 1);
        $res = xmlwriter_set_indent_string($xw, ' ');
    
        xmlwriter_start_document($xw, '1.0', 'UTF-8');
    
        // Первый элемент
        xmlwriter_start_element($xw, 'urlset');
    
        // Атрибут 'att1' для элемента 'tag1'
        xmlwriter_start_attribute($xw, 'xmlns');
        xmlwriter_text($xw, 'http://www.sitemaps.org/schemas/sitemap/0.9');
        xmlwriter_end_attribute($xw);
        
        xmlwriter_start_element($xw, 'url');
            xmlwriter_start_element($xw, 'loc');
                xmlwriter_text($xw, 'sss');
            xmlwriter_end_element($xw); // loc
            xmlwriter_start_element($xw, 'lastmod');
                xmlwriter_text($xw, date("c"));
            xmlwriter_end_element($xw); // loc
            xmlwriter_start_element($xw, 'priority');
                xmlwriter_text($xw, '1.0');
            xmlwriter_end_element($xw); // loc
        xmlwriter_end_element($xw); // url
 
    
        xmlwriter_end_element($xw); // urlset
    
    
        xmlwriter_end_document($xw);
        */
        //file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/avar_sitemap.xml", xmlwriter_output_memory($xw)); 
    }
   
?>