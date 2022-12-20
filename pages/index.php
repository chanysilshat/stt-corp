
<?
    $PROJECT->includeController(
        "avarcom", 
        "avarcom",
        [
            "tables_list" => "/admin/tables/",
            "detail_table" => "/admin/tables/#table_name#/",
            "detail_entry" => "/admin/tables/#table_name#/detail/#entry#/",
            "add_entry" => "/admin/tables/#table_name#/add/",
        ]
    ); 

?>