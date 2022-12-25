<?
class InstallCore extends Install{

    protected $tables = [
        "stt_user_group_table" => [
            "id" => "INT AUTO_INCREMENT",
            "group_code" => "VARCHAR(255)",
            "name" => "VARCHAR(255)",
            "PRIMARY KEY" => "(id)",
        ],
        "stt_users" => [
            "id" => "INT AUTO_INCREMENT",
            "user_name" => "VARCHAR(255)",
            "last_name" => "VARCHAR(255)",
            "user_group" => "INT",
            "login" => "VARCHAR(255)",
            "password" => "VARCHAR(255)",
            "hash" => "VARCHAR(255)",
            "PRIMARY KEY" => "(id)",
        ],
        "stt_access_list_table" => [
            "id" => "INT AUTO_INCREMENT",
            "access_list_name" => "VARCHAR(255)",
            "attribute" => "VARCHAR(255)",
            "desctiption" => "VARCHAR(255)",
            "PRIMARY KEY" => "(id)",
        ],
        "stt_access_table" => [
            "id" => "INT AUTO_INCREMENT",
            "access_name" => "VARCHAR(255)", //Название таблиц
            "access" => "INT",
            "user_group" => "INT",
            "PRIMARY KEY" => "(id)",
        ],  
        "stt_url_address" => [
            "id" => "INT AUTO_INCREMENT",
            "page_condition" => "VARCHAR(255)", //Название таблиц
            "manage_file" => "VARCHAR(255)", //Название таблиц
            "page_request" => "VARCHAR(255)",
            "PRIMARY KEY" => "(id)",
        ], 
        "stt_configs" => [
            "id" => "INT AUTO_INCREMENT",
            "config_name" => "VARCHAR(255)",
            "config_code" => "VARCHAR(255)",
            "config_value" => "VARCHAR(255)",
            "module_code" => "VARCHAR(255)",
            "PRIMARY KEY" => "(id)",
        ]
    ];

    protected $connectionsFromTables = [
        [
            "INSIDE" => [
                "TABLE" => "stt_users",
                "KEY" => "user_group",
            ],
            "FORIGEN" => [
                "TABLE" => "stt_user_group_table",
                "KEY" => "id",
            ]
        ],
        [
            "INSIDE" => [
                "TABLE" => "stt_access_table",
                "KEY" => "user_group",
            ],
            "FORIGEN" => [
                "TABLE" => "stt_user_group_table",
                "KEY" => "id",
            ]
        ],
        [
            "INSIDE" => [
                "TABLE" => "stt_access_table",
                "KEY" => "access",
            ],
            "FORIGEN" => [
                "TABLE" => "stt_access_list_table",
                "KEY" => "id",
            ]
        ],
    ];

    protected $defaultValues = [
        "stt_user_group_table" => [
            [
                "group_code" => "admin",
                "name" => "Администраторы",
            ], 
            [
                "group_code" => "manager",
                "name" => "Менеджеры",
            ], 
        ],
        "stt_url_address" => [
            [
                
                "page_condition" => "/admin/modules/#module_code#",
                "manage_file" => "/stt/admin/module.php",
                "page_request" => "",
            ],
            [
             
                "page_condition" => "/admin/tables/",
                "manage_file" => "/stt/admin/tables.php",
                "page_request" => "",
            ],
            [
  
                "page_condition" => "/admin/tables/#detail_table#",
                "manage_file" => "/stt/admin/tables.php",
                "page_request" => "",
            ],
            [
     
                "page_condition" => "/admin/tables/#detail_table#/detail/#detail_entry#/",
                "manage_file" => "/stt/admin/tables.php",
                "page_request" => "",
            ],
            [
        
                "page_condition" => "/admin/tables/#detail_table#/#handler#/",
                "manage_file" => "/stt/admin/tables.php",
                "page_request" => "",
            ],
            [   

                "page_condition" => "/admin/modules/",
                "manage_file" => "/stt/admin/module.php",
                "page_request" => "",
            ],
        ], 
    ];

    public function afterSetDefaultValues(){

        global $User;
        $User->registerUser("admin", "123456");
    }

}

?> 