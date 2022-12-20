<?
class AvarcomStatistics extends Controller
{
    public $arParams = [];
    protected $arData = [];

    public function executeController()
    {
        global $PROJECT;

        
        $PROJECT->title = "Статистика аварком";

        $table = "avarcom_stat_visitor_ip";
        $res = $PROJECT->objects["TABLES"]->getList($table, [], []);
        foreach ($res as $item){
            $items[date("d.m.Y H:00:00", strtotime($item["date_first"]))]++; 
        }
     
        ksort($items);
        $new["COLOR"] = "#15fb2f";
        foreach ($items as $key => $item){
          
            $new["ITEMS"][] = [
                "X_VALUE" => date("d.m.Y H:i:s", strtotime($key)),
                "Y_VALUE" => $item,
                "INFO" => date("d.m.Y H:i:s", strtotime($key)) . "<br>Новых пользователей " . $item
            ];
            $maxDate = date("d.m.Y H:i:s", strtotime($key));

            if (empty($minDate)){
                $minDate = date("d.m.Y H:i:s", strtotime($key));
            }
        }

        $table = "avarcom_stat_history";
        $res = $PROJECT->objects["TABLES"]->getList($table, [], []);
        foreach ($res as $item){
            $items[date("d.m.Y H:00:00", strtotime($item["date_in"]))]++; 
        }
     
        ksort($items);
        $active["COLOR"] = "#d91717";
        foreach ($items as $key => $item){
          
            $active["ITEMS"][] = [
                "X_VALUE" => date("d.m.Y H:i:s", strtotime($key)),
                "Y_VALUE" => $item,
                "INFO" => date("d.m.Y H:i:s", strtotime($key)) . "<br>Активных действий " . $item
            ];
            
            if (date("d.m.Y H:i:s", strtotime($key)) > $maxDate){
                $maxDate = date("d.m.Y H:i:s", strtotime($key));
            }
            if ($minDate > date("d.m.Y H:i:s", strtotime($key))){
                $minDate = date("d.m.Y H:i:s", strtotime($key));
            }
        }

        
        $arData = [
            "HEIGHT" => 600,
            "WIDTH" => 1000,
            "START_X" => 90,
            "Y_LABEL" => [
                "TYPE" => "NUMBER",
                "MIN" => 0,
                "MAX" => max($items) + 5,
                "COUNT" => 4,
            ],
            "Y_LABEL_TITLE" => "",
            "X_LABEL" => [
                "TYPE" => "DATE",
                "MIN" => strtotime($minDate),
                "MAX" =>  strtotime($maxDate),
                "COUNT" => 4,
            ],
            "X_LABEL_TITLE" => "Дата",
            "X_DATE_FORMAT" => "d.m.Y H:i:s",
            "DATA" => [
                $new,
                $active
            ]
        ];
        $this->arData = $arData;
        $this->includeControllerView();
    } 
} 