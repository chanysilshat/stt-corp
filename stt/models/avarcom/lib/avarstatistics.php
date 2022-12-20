<?php
 class AvarStatistics extends Tables
 {
    private $refer;
    private $browser;
    private $ip;
    private $url;
    private $yandexID;
    
    public function __construct()
    {

  
    }

    public function writeStatistics($statArray)
    {
        $this->refer = $statArray["refer"];
        $this->browser = $statArray["browser"];
        $this->ip = $statArray["ip"];
        $this->url = $statArray["url"];
        $this->yandexID = $statArray["yandexID"];
        $this->date = date("c");

        $this->writeVisitor_ip();
        $this->writeVisitor_yandex();
        $this->writeVisitor_refers();
        $this->writeVisitor_history();

    }

    private function writeVisitor_yandex()
    {
        if (!empty($this->yandexID)){
            $table = "avarcom_stat_visitor_yandex";
            $filter = [
                "yandexID" => $this->yandexID
            ];
            $res = $this->getList($table, [], $filter);
            if (empty($res)){
                $arFields = [
                    "ip" => $this->ip,
                    "yandexID" => $this->yandexID,
                    "browser" => $this->browser,
                    "date_first" => $this->date,
                    "date_last" => $this->date
                ];
                $this->insertIntoTable($table, $arFields);
            } else {
                $id = $res[0]["id"];
                $res[0]["date_last"] = $this->date;
                $this->updateTableByID($table, $res[0], $id);

            }
        }
    }

    private function writeVisitor_refers()
    {
        if (!empty($this->refer)){
            if (strpos($this->refer, "stt-corp.ru") !== false){
                
            } else {
                $table = "avarcom_stat_visitor_refers";
                $filter = [
                    "yandexID" => $this->yandexID,
                    "ip" => $this->ip,
                    "refer" => $this->refer,
                ];
                $res = $this->getList($table, [], $filter);
                if (empty($res)){
                    $arFields = [
                        "ip" => $this->ip,
                        "yandexID" => $this->yandexID,
                        "refer" => $this->refer,
                        "date_first" => $this->date,
                        "date_last" => $this->date
                    ];
                    $this->insertIntoTable($table, $arFields);
                } else {
                    $id = $res[0]["id"];
                    $res[0]["date_last"] = $this->date;
                    $this->updateTableByID($table, $res[0], $id);
    
                }
            }
            
        }
    }

    private function writeVisitor_history()
    {
        if (!empty($this->ip)){
            $table = "avarcom_stat_history";

            $arFields = [
                "ip" => $this->ip,
                "yandexID" => $this->yandexID,
                "url" => $this->url,
                "date_in" => $this->date
            ];
            $this->insertIntoTable($table, $arFields);
        }
       
    }

    private function writeVisitor_ip()
    {
        if (!empty($this->ip)){
            $table = "avarcom_stat_visitor_ip";
            $filter = [
                "ip" => $this->ip
            ];
            $res = $this->getList($table, [], $filter);
            if (empty($res)){
                $arFields = [
                    "ip" => $this->ip,
                    "date_first" => $this->date,
                    "date_last" => $this->date
                ];
                $this->insertIntoTable($table, $arFields);
            } else {
                $id = $res[0]["id"];
                $res[0]["date_last"] = $this->date;
                $this->updateTableByID($table, $res[0], $id);

            }
        }
    }

 }