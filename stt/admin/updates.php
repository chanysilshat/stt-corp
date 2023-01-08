<?
    $PROJECT::includeModules("rest");
    $RestModule = new RestModule();

    $url = "https://stt-corp.ru/updates/";
    $OutRest = new OutRest();
    $OutRest->rest["update"] = $url;
    $OutRest->setUrl($url);
    $data = [
        "header_mode" => 0,
        "load_script" => 0,
        "load_css" => 0,
    ];
    echo  "<pre>"; print_r($OutRest->executeMethod("update", $data)); echo "</pre>";
?>