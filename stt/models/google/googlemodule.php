<?
class GoogleModule extends Module{

    protected $moduleName = "google";
    protected $moduleTitle = "Google";
    protected $arFields = [
      
    ];

    public function executeModule(){
        require_once  $_SERVER["DOCUMENT_ROOT"] . '/stt/models/google/vendor/autoload.php';
    } 
}
