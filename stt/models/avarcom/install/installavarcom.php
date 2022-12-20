<?
class InstallAvarcom extends Install{

    protected $tables = [
        "avarcom_pages" => [
            "id" => "INT AUTO_INCREMENT",
            "city" => "VARCHAR(255)",
            "city_code" => "VARCHAR(255)",
            "page_title" => "VARCHAR(255)",
            "keywords" => "VARCHAR(255)",
            "description" => "VARCHAR(255)",
            "h1" => "VARCHAR(255)",
            "map_where" => "VARCHAR(255)",
            "map_address" => "VARCHAR(255)",
            "map_address_info" => "VARCHAR(255)",
            "PRIMARY KEY" => "(id)",
        ],
        "avarcom_stat_visitor_ip" => [
            "id" => "INT AUTO_INCREMENT",
            "ip" => "VARCHAR(255)",
            "date_first" => "VARCHAR(255)",
            "date_last" => "VARCHAR(255)",
            "PRIMARY KEY" => "(id)",
        ],

        "avarcom_stat_visitor_yandex" => [
            "id" => "INT AUTO_INCREMENT",
            "ip" => "VARCHAR(255)",
            "yandexID" => "VARCHAR(255)",
            "browser" => "VARCHAR(255)",
            "date_first" => "VARCHAR(255)",
            "date_last" => "VARCHAR(255)",
            "PRIMARY KEY" => "(id)",
        ],

        "avarcom_stat_visitor_refers" => [
            "id" => "INT AUTO_INCREMENT",
            "ip" => "VARCHAR(255)",
            "yandexID" => "VARCHAR(255)",
            "refer" => "VARCHAR(255)",
            "date_first" => "VARCHAR(255)",
            "date_last" => "VARCHAR(255)",
            "PRIMARY KEY" => "(id)",
        ],

        "avarcom_stat_history" => [
            "id" => "INT AUTO_INCREMENT",
            "ip" => "VARCHAR(255)",
            "yandexID" => "VARCHAR(255)",
            "url" => "VARCHAR(255)",
            "date_in" => "VARCHAR(255)",
            "PRIMARY KEY" => "(id)",
        ],
    ];

    protected $defaultValues = [
        "stt_url_address" => [
            [

                "page_condition" => "/#city#/",
                "manage_file" => "/pages/index.php",
                "page_request" => "",
            ],
           
        ], 
    ]; 
    
    public function beforeSetDefaultValues(){
        $fileName = $_SERVER["DOCUMENT_ROOT"] . "/stt/json/database/avarcom_pages.json";

        if (file_exists($fileName)){
            $data = json_decode(file_get_contents($fileName), true);
            $this->defaultValues["avarcom_pages"] = $data;
        }
    }

}

?> 