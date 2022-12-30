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

    public function executeModule(){
       
    } 
}
