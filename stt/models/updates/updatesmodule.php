<?
class UpdatesModule extends Module{

    protected $moduleName = "updates";
    protected $moduleTitle = "Система обновлений";

    protected $arFields = [
        "lib" => [
            "updaterest"
        ]
    ];

    protected $moduleFilesList = [

    ];
    
    public function executeModule()
    {
         
    }

    public function beforeExecuteModule()
    {
        global $PROJECT; 
        $PROJECT::includeModules("rest");
        $RestModule = new RestModule();
    }
}
