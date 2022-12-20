<?
    require_once(__DIR__."/autoloader.php");
    $arFields = [
        "globals" => [
            "project",
            "page"
        ],
        "extends" => [
            "database",
            "module",
        ],
        "lib" => [
            "core", //Ядро проекта
            "stt", //
        ],
    ];

    
    $Load = new AutoLoaderModels("core");
    $Load->includeClass($arFields);

    $stt = new STT();
    global $dbconnect;
    global $PROJECT;
    global $User;
    global $Session;
    $PROJECT = new Project();
    $PROJECT::includeModules("core");

    
    $PROJECT->setObject("STT", $stt);
    $PROJECT->setObject("Core", $stt->core);
    $PROJECT->setObject("AutoLoad", $Load);
    $stt->setAutoLoadedObject($Load);
    //Старт проекта
    $stt->startProject();
    





    