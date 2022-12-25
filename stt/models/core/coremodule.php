<?
class CoreModule extends Module{

    protected $moduleName = "core";
    protected $moduleTitle = "Ядро проекта";

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
