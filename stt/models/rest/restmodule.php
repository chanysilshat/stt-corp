<?
class RestModule extends Module{

    protected $moduleName = "rest";
    protected $moduleTitle = "Rest";
    protected $arFields = [
        "lib" => [
            "outrest"
        ]
    ];

    public function executeModule(){
        //echo "<pre>"; print_r($_SERVER); echo "</pre>";
    } 
}