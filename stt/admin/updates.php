<?
    $PROJECT::includeModules("updates");


 
    $UpdateRest = new UpdateRest();
    //$UpdateRest->rest["get.modules.info"] = $url;
    
    $data = [
        //"header_mode" => 0,
        //"load_script" => 0,
        //"load_css" => 0,
    ];

    echo  "<pre>"; print_r($UpdateRest->executeMethod("get.modules.info", $data)); echo "</pre>";
?>