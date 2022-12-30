<?
class AvarcomController extends Controller
{
    public $arParams = [];
    protected $arData = [];

    public function executeController(){

      

        global $PROJECT;
        $PROJECT::includeModules("avarcom");
        $this->setStatistics();
        $table = "avarcom_pages";

        $PROJECT->projectJsScripts[] = "/dtp_media/js/script.js";
        $PROJECT->projectJsScripts[] = "/dtp_media/plugins/stt-modal/modal.js";
        $PROJECT->projectStyles[] = "/dtp_media/plugins/stt-modal/modal.css";

        if (isset($_REQUEST["DYNAMICS_PAGE"]["city"])){
        
            $res = $PROJECT->objects["TABLES"]->getTableArray($table, [], ["city_code" => $_REQUEST["DYNAMICS_PAGE"]["city"]]);
            $this->arData["AVARCOM"] = $PROJECT->objects["TABLES"]->getTableArray($table, [], []);

            if (!empty($res["data"])){

                $city = $res["data"][0]["city"];
                $city_code = $res["data"][0]["city_code"];
                $page_title = $res["data"][0]["page_title"];
                $keywords = $res["data"][0]["keywords"];
                $description = $res["data"][0]["description"];
                $canonical = $res["data"][0]["canonical"];
                $h1 = $res["data"][0]["h1"];
                $map_where = $res["data"][0]["map_where"];
                $map_address = $res["data"][0]["map_address"];
                $map_address_info = $res["data"][0]["map_address_info"];

                $PROJECT->title = $page_title;
                $PROJECT->keywords = $keywords;
                $PROJECT->description = $description;
                $PROJECT->canonical = $canonical;

                ob_start();
                $this->includeControllerView();
                $page = ob_get_contents();
                ob_end_clean();
                $page = str_replace("#CITY#", $city, $page);
                $page = str_replace("#H1#", $h1, $page);
                $page = str_replace("#MAP_WHERE#", $map_where, $page);
                $page = str_replace("#ADDRESS#", $map_address, $page);
                $page = str_replace("#ADRESS_INFO#", $map_address_info, $page);

                ob_start();
                    $this->includeControllerView("region");
                    $region = ob_get_contents();
                ob_end_clean();

                $page = str_replace("#REGION_LIST#", $region, $page);

                echo $page;

            } else {
                $this->includeControllerView("404"); 
            }

        } else {

            $city = "Уфа";
            $h1 = "Аварийный комиссар Уфа";
            $map_where = "города Уфы";
            $map_address = "город Уфа, улица Лесотехникума 20/1";
            $map_address_info = "Тел. 8(347) 237-02-02; 248-81-02";
            $keywords = "дтп, оформление дтп, комиссары уфы, район, город, европротокол, еврик, вызвать гаи в уфе, услуги эвакуатора, военный, комиссар,аварийный комиссар, дорожный комиссар, автокомиссар, автоюрист, сотрудник гибдд, сотрудник гаи, дтп без гаи, дтп без гибдд, каск";
            $page_title = "Аварийный комиссар Уфа. Тел. +7(927)237-46-48. ДТП без ГАИ и ГИБДД. Вызов аварийного комиссара.";
            $description = "Эксперт по вопросам ДТП. Необходимое составление материала по ОСАГО и КАСКО. Привлечение сотрудников ГИБДД, при необходимости вызов эвакуатора. Быстро прибудут в любую точку города.";
            $PROJECT->title = $page_title;
            $PROJECT->keywords = $keywords;
            $PROJECT->description = $description;

            $this->arData["AVARCOM"] = $PROJECT->objects["TABLES"]->getTableArray($table, [], []);

            ob_start();
            $this->includeControllerView();
            $page = ob_get_contents();
    
            ob_end_clean();

            ob_start();
            $this->includeControllerView("region");
            $region = ob_get_contents();
            ob_end_clean();

            $page = str_replace("#REGION_LIST#", $region, $page);

            $page = str_replace("#CITY#", $city, $page);
            $page = str_replace("#H1#", $h1, $page);
            $page = str_replace("#MAP_WHERE#", $map_where, $page);
            $page = str_replace("#ADDRESS#", $map_address, $page);
            $page = str_replace("#ADRESS_INFO#", $map_address_info, $page);

            echo $page;
        }
    } 

    private function setStatistics(){
        if (isset($_REQUEST["avar_stat"])){
            
            global $PROJECT;
            $PROJECT::includeModules("avarcom");
            $AvarcomModule = new AvarcomModule();
            $statArray = $_REQUEST["avar_stat"];
          
            $AvarStatistics = new AvarStatistics();
            $AvarStatistics->setDataBaseObject($PROJECT->objects["Core"]->DataBaseObject);
            $AvarStatistics->writeStatistics($statArray);

        }
    }
} 