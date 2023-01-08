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
        //echo "<pre>"; print_r($_SERVER); echo "</pre>";
         
    }

    public function beforeExecuteModule()
    {
        global $PROJECT; 
        $PROJECT::includeModules("rest");

    }
}
