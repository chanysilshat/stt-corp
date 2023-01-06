<?
class AvarcomModule extends Module{

    protected $moduleName = "avarcom";
    protected $moduleTitle = "Аварком";
    protected $arFields = [
        "lib" => [
            "avarcomgoogle", 
            "avarcomtelegram", 
            "avarstatistics", 
            "avarcommanage", 
        ], 
    ];

    protected $controllersList = [
        "avarcom" => [

        ],
        "avarcom-manage" => [

        ],
        "avarcom-statistics" => [

        ]
    ];

    public function executeModule(){
       //echo "<pre>"; print_r($this->controllersList); echo "</pre>";
    } 
}
