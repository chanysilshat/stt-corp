<?
class StoreModule extends Module{

    protected $moduleName = "store";
    protected $moduleTitle = "Store";

    protected $dependency = [
        "core" => [
            1,
        ],
        "google" => [
            1,
        ],
        "telegram" => [
            1,
        ],
        
    ];
    
    protected $arFields = [
      
    ];

    public function executeModule(){
         
    } 
}