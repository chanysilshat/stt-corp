<?
final class B24Module extends Module
{

    protected $moduleName = "b24";
    protected $moduleTitle = "Bitrix24";
    protected $controllersList = [];
    protected $controllersPath = [];
    protected $controllersObject = [];

    protected $arFields = [
        "lib" => [
            "b24rest"
        ]
    ];

    public function beforeExecuteModule(){
        global $PROJECT;
        $PROJECT::includeModules("rest");
        $RestModule = new RestModule();
    }

    public function executeModule(){
        
    }
}