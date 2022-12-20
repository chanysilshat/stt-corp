<?
    class Core{

        public $DataBaseObject;
        private $loadedObject;
        public $header = 1;
        public $load_script = 0;
        public $load_css = 0;
        private $headView = "";
        private $headerView = "";
        private $footerView = "";
        
        public function __construct(){
            $this->DataBaseObject = new DataBase();
            if (isset($_REQUEST["header_mode"])){
                $this->header = $_REQUEST["header_mode"];
                if (isset($_REQUEST["load_script"])){
                    $this->load_script = $_REQUEST["load_script"];
                } else {
                    $this->load_script = false;
                }
                if (isset($_REQUEST["load_css"])){
                    $this->load_css = $_REQUEST["load_css"];
                } else {
                    $this->load_script = false;
                }
            }
         
      
        }   

        //Подключение конфигурационных файлов
        private function includeConfigs(){

            $fullFileName = $_SERVER["DOCUMENT_ROOT"] . "/stt/configs/define.php";

            if (file_exists($fullFileName)){
                require_once $fullFileName;
            } else {
                die("Отсутствует файл констант");
            }

            $fullFileName = $_SERVER["DOCUMENT_ROOT"] . "/stt/configs/config.php";
            
            if (file_exists($fullFileName)){
                require_once $fullFileName;
            } else {
                die("Отсутствует конфигурационный файл");
            }

            $fullFileName = $_SERVER["DOCUMENT_ROOT"] . "/stt/configs/dbconnect.php";
            
            if (file_exists($fullFileName)){
                require_once $fullFileName;
                global $dbconnect;
                $this->DataBaseObject->dbconnect = $dbconnect;
            } else {
                die("Отсутствует файл подключения к БД");
            }

            return 1;
        }

        //Предварительная проверка
        private function preTesting(){

            if (PRETESTING){
                if ($this->DataBaseObject->checkConnect()){
                    if ($this->DataBaseObject->checkConnectDataBase()){
                        return true;
                    } else {
                        die("Предварительное тестирование не пройдено. Проект не запустится");
                    }
                } else {
                    die("Предварительное тестирование не пройдено. Проект не запустится");
                }
            }
            else {
                return true;
            }
        }
 
        //Подключение шапки
        private function includeHeader(){
            if ($this->header){
                       
                echo "<html>";
                echo "<head>";
                require_once $this->headView;
                echo "</head>";
                echo "<body>";
                require_once $this->headerView;

            }
        }

        //Подключение шапки ядра ()
        private function includeCoreHeader(){
 
            if ($this->includeConfigs()){
                if ($this->preTesting()){

                   

                } else {
                    die("Ошибка запуска проекта");
                }
            } 
        }
 
        //Подключение подвала ядра (без UI)   
        private function includeCoreFooter(){
            if ($this->header){
                require_once $this->footerView;
                echo "</body>";
                echo "</html>";
            } 
        }

        //Подключение страниц
        private function includePage($pageName = "/"){


            $requestUri = $_SERVER["REQUEST_URI"];

            $manageFile = "";

            global $PROJECT;
            global $User;
            global $Session;
            
            $this->headView = $_SERVER["DOCUMENT_ROOT"] . "/stt/views/panel/admin/head.php";
            $this->headerView = $_SERVER["DOCUMENT_ROOT"] . "/stt/views/panel/admin/header.php";
            $this->footerView = $_SERVER["DOCUMENT_ROOT"] . "/stt/views/panel/admin/footer.php";
            
           

            $PROJECT::includeModules("core");

            $Session = new Session();
            $PROJECT->setSessionObject($Session);

            $this->includeCoreHeader();
            
            $stt_url_address = "";
            $tablesDB = $PROJECT->objects["TABLES"]->getTables();
            foreach ($tablesDB as $table){
                if ($table == "stt_url_address"){
                    $stt_url_address = "stt_url_address";
                    break;
                }
            }

            if (!empty($stt_url_address)){
                
                $urlRuleList = $PROJECT->objects["TABLES"]->getList("stt_url_address", "", "");


                $requestUri = $_SERVER["REQUEST_URI"];
                $explodePage = explode("?", $requestUri);
                $explodeUri = explode("/", $explodePage[0]);
                foreach ($explodeUri as $key => $uri){
                    if (empty($uri)){
                        unset($explodeUri[$key]);
                    }
                }
                foreach ($urlRuleList as $key => $urlRule){
                    $explodeContition[$key] = explode("/", $urlRule["page_condition"]);
    
                    foreach ($explodeContition[$key] as $cKey => $condition){
                        $condition = str_replace(" ", "", $condition);
                        if (empty($condition) || strlen($condition) == 0){
                            unset($explodeContition[$key][$cKey]);
                        }
                    } 
    
                    if (count($explodeUri) != count($explodeContition[$key])){
                        unset($explodeContition[$key]);
                    }
    
                }
      
                foreach ($explodeContition as $key => $condition){
                    $searchCondition[$key] = 0;
                    foreach ($condition as $pKey => $params){
                        if ($params == $explodeUri[$pKey]){
                            $searchCondition[$key]++;
                        } else {
                            if ($params[0] != "#" && $params[strlen($params) - 1] != "#"){
                                unset($explodeContition[$key]);
                                unset($searchCondition[$key]);
                                break;
                            } else {
                                $_REQUEST["DYNAMICS_PAGE"][str_replace("#", "", $params)] = $explodeUri[$pKey];
                            }
                        }
                    }
                }
                arsort($searchCondition);
                if (!empty($searchCondition)){
                    $keys = array_keys($searchCondition);
                    $keyPage = $keys[0];
                    $manageFile = $urlRuleList[$keyPage]["manage_file"];
    
                }
            }
    

            if (isset($_GET)){
                $explode = explode("?", $pageName);
                $pageName = $explode[0];
            }

            if ($pageName == "/"){
                $pageName = "index.php";
            }
            if (substr($pageName, -4) != ".php" && substr($pageName, -1) != "/" && strpos($pageName, "?") === false){
                $pageName .= "/index.php";
            }
            if (substr($pageName, -1) == "/"){
                $pageName .= "index.php";
            }
    
            $pos = strpos($pageName, "/admin");
        
            if (strpos($pageName, "/install") !== false){
                $fullFileName = $_SERVER["DOCUMENT_ROOT"] . "/stt/models/core/install.php";
             

                $this->headView = $_SERVER["DOCUMENT_ROOT"] . "/stt/views/panel/admin/head.php";
                $this->headerView = $_SERVER["DOCUMENT_ROOT"] . "/stt/views/panel/admin/header.php";
                $this->footerView = $_SERVER["DOCUMENT_ROOT"] . "/stt/views/panel/admin/footer.php";
                
                $arFields = [
                    "extends" => [
                        "install", //
                    ],
                    "install" => [
                        "installmodules", //Ядро проекта
                    ],
                ];
                $this->$loadedObject->moduleName = "core";
                $this->$loadedObject->includeClass($arFields);
                //require_once $fullFileName;

            } elseif($pos === false){
    
                $fullFileName = $_SERVER["DOCUMENT_ROOT"] . "/pages/" . $pageName;
                $this->headView = $_SERVER["DOCUMENT_ROOT"] . "/stt/views/site/" . SITE_VIEW . "/head.php";
                $this->headerView = $_SERVER["DOCUMENT_ROOT"] . "/stt/views/site/" . SITE_VIEW . "/header.php";
                $this->footerView = $_SERVER["DOCUMENT_ROOT"] . "/stt/views/site/" . SITE_VIEW . "/footer.php";
            } else {
                $PROJECT->projectJsScripts[] = "/stt/js/sttadminpanel.js";
                $PROJECT->projectJsScripts[] = "/stt/js/stttables.js";

                $PROJECT->projectStyles[] = "/stt/css/sttadminpanel.css";
                $PROJECT->projectStyles[] = "/stt/css/stttables.css";
                $fullFileName = $_SERVER["DOCUMENT_ROOT"] . "/stt/" . $pageName;
                $this->headView = $_SERVER["DOCUMENT_ROOT"] . "/stt/views/panel/admin/head.php";
                $this->headerView = $_SERVER["DOCUMENT_ROOT"] . "/stt/views/panel/admin/header.php";
                $this->footerView = $_SERVER["DOCUMENT_ROOT"] . "/stt/views/panel/admin/footer.php";
            }
       
            $this->includeHeader();
            
            if (file_exists($fullFileName)){
                require_once ($fullFileName);

                //$fullFileName = $fullFileName;
   
            } elseif (file_exists($_SERVER["DOCUMENT_ROOT"] . $manageFile)){
                if (!empty($manageFile)){
                    $fullFileName = $_SERVER["DOCUMENT_ROOT"] . $manageFile;
                    require_once ($_SERVER["DOCUMENT_ROOT"] . $manageFile);
                } else {
                    require_once ($_SERVER["DOCUMENT_ROOT"] . "/pages/404.php");
                    //$fullFileName = $_SERVER["DOCUMENT_ROOT"] . "/pages/404.php";
                }

            } else {
          
                require_once ($_SERVER["DOCUMENT_ROOT"] . "/pages/404.php");
                //require_once ($fullFileName);

            }

            $this->includeCoreFooter();
        }

        //Подключение подвала

        public function openPage($pageName){
            $this->includePage($pageName);
        }

        private function includeViewHead(){

        }

        private function includeViewFooter(){
            
        }

    }
 ?>