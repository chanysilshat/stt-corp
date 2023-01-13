<?
class TelegramModule extends Module{

    protected $moduleName = "telegram";
    protected $moduleTitle = "Telegram";

    protected $dependency = [
        "core" => [
            1,
        ],
        "rest" => [
            1,
        ],
    ];

    protected $arFields = [
        "lib" => [
            "telegrambot"
        ]
    ];

    //Перед исполнением
    public function beforeExecuteModule(){
        global $PROJECT;
        $PROJECT::includeModules("rest");
        $RestModule = new RestModule();
    }

    public function executeModule(){
  
    }
}