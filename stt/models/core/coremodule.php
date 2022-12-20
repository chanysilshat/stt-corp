<?
class CoreModule extends Module{

    protected $moduleName = "core";
    protected $moduleTitle = "Ядро проекта";

    protected $arFields = [
        "extends" => [
            "database",
            "tables",
            "module",
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
        ], 
        "manage" => ["manage"],
    ];

    public function executeModule(){
        global $PROJECT;
        global $User;

        
        $User = new User();

        $tables = new Tables();
        $tables->setDataBaseObject($PROJECT->objects["Core"]->DataBaseObject);
        $User->setTablesObject($tables);
        
        $PROJECT->setObject("TABLES", $tables);
    }
}
