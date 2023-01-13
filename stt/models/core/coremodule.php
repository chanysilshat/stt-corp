<?

class CoreModule extends Module{

    protected $moduleName = "core";
    protected $moduleTitle = "Ядро проекта";
    protected $version = 1;

    protected $arFields = [
        "extends" => [
            "database",
            "tables",
            "module",
            "structuresystem",
        ],
        "globals" => [
            "session",
            "page", 
            "user"
        ],
        "lib" => [
            "core", //Ядро проекта
            "Crypter",
            "stt", //
            "archive", //
            "sttconfigs", //
        ], 
        "manage" => ["manage"],
    ];

    protected $controllersList = [
        "tables" => [
            "table"
        ]
    ];

    protected $moduleFilesList = [
        "/index.php",
        "/stt/initialization.php",
        "/stt/admin/ajax_settings.php",
        "/stt/css/sttadminpanel.css",
        "/stt/css/stttables.css",
        "/stt/css/style.css",
        "/stt/js/script.js",
        "/stt/stttables.js",
        "/stt/views/panel/admin/footer.php",
        "/stt/views/panel/admin/head.php",
        "/stt/views/panel/admin/header.php",
    ];
    
    public function executeModule(){
        global $PROJECT;
        global $User;

        
        $User = new User();
        $tables = new Tables();
        $Configs = new STTConfig();

        $tables->setDataBaseObject($PROJECT->objects["Core"]->DataBaseObject);
        $User->setTablesObject($tables);
        
        $Configs->setDataBaseObject($PROJECT->objects["Core"]->DataBaseObject);
        $Configs->setTablesObject($tables);

        $PROJECT->setObject("TABLES", $tables);
        $PROJECT->setConfigObject($Configs);
        
    }

    
}
