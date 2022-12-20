<?
class InstallContent extends Install{

    protected $tables = [
        "stt_content_table" => [
            "id" => "INT AUTO_INCREMENT",
            "group_code" => "VARCHAR(255)",
            "name" => "VARCHAR(255)",
            "PRIMARY KEY" => "(id)",
        ],
    ];

}

?> 