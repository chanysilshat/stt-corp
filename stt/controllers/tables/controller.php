<?
class TablesController extends Controller
{
    public $arParams = [];
    protected $arData = [];

    public function executeController(){
        global $PROJECT;

        $PROJECT->title = "Таблицы";

        if (isset($_REQUEST["table-handler"]) && !empty($_REQUEST["table-handler"])){
            $handler = $_REQUEST["table-handler"]["handler"];
            $data = $_REQUEST["table-handler"]["data"];
            $table = $_REQUEST["table-handler"]["table"];
            if ($handler == "add"){
                if (!empty($table)){
                    $PROJECT->objects["TABLES"]->insertIntoTable($table, $data);
                }
            }

            if ($handler == "update"){
                if (!empty($table)){
                    $filter = [
                        "id" => $data["id"],
                    ];
                    $PROJECT->objects["TABLES"]->updateTableByID($table, $data, $data["id"]);
                }
            }

            if ($handler == "delete"){
                $table = $_REQUEST["table-handler"]["table"];
                $where = "id=" . $_REQUEST["table-handler"]["data"]["id"];
                $PROJECT->objects["TABLES"]->deleteFromTable($table, $where);

            }

          
        }

       
        if (empty($_REQUEST["DYNAMICS_PAGE"])){
            $tables = $PROJECT->objects["TABLES"]->getTables();
        
            $this->arData["COL_NAME"] = [
                "TABLE_NAME" => "Название таблицы"
            ];
            
            foreach ($tables as $table){
                $this->arData["ROW"][] = [
                    "DETAIL_URL" => str_replace("#table_name#", $table, $this->arParams["detail_table"]),
                    "EDIT_ENTRY" => "N",
                    "FIELDS" => [
                        "TABLE_NAME" => $table
                    ]
                ];
            }
            $this->includeControllerView();
            
        } elseif (empty($_REQUEST["DYNAMICS_PAGE"]["detail_entry"])){

            $table = $_REQUEST["DYNAMICS_PAGE"]["detail_table"];
            
          
            $res = $PROJECT->objects["TABLES"]->getTableArray($table, [], []);
            
            $this->arParams['detail_entry'] = str_replace("#table_name#", $table, $this->arParams["detail_entry"]);


            foreach ($res['data'] as $key => $value){
                $res["DETAIL_URL"][$key] = str_replace("#entry#", $value["id"], $this->arParams["detail_entry"]);
            }

            $this->arData = $res;

            if (!empty($_REQUEST["DYNAMICS_PAGE"]["handler"]) && $_REQUEST["DYNAMICS_PAGE"]["handler"] == "add"){

                $informationSchema = $PROJECT->objects["TABLES"]->getInformationSchema($table);
                $keyColumnUsage = $PROJECT->objects["TABLES"]->getKeyColumnUsage($table);
                $foreginData = [];

                foreach ($keyColumnUsage as $column){
                    if (isset($informationSchema[$column["COLUMN_NAME"]])){
                        if (!empty($column["REFERENCED_TABLE_NAME"])){
                            $foregin[$column["COLUMN_NAME"]]["reference_column"] = $column["REFERENCED_COLUMN_NAME"];
                            $foregin[$column["COLUMN_NAME"]]["table"] = $column["REFERENCED_TABLE_NAME"];
                            $foreginData[$column["REFERENCED_TABLE_NAME"]] = $PROJECT->objects["TABLES"]->getList($column["REFERENCED_TABLE_NAME"], [], []);
                        }
                    }
                }
                unset($informationSchema["id"]);

                $result["columns"] = $informationSchema;
                $result["foregin"] = $foregin;
                $result["foreginData"] = $foreginData;


                $this->arData = $result;

                $this->includeControllerView("add-entry");
            } else {
                $this->includeControllerView("detail");
            }

        } else {
            if (!empty($_REQUEST["DYNAMICS_PAGE"]["detail_entry"]) && !empty($_REQUEST["DYNAMICS_PAGE"]["detail_table"])){

                $table = $_REQUEST["DYNAMICS_PAGE"]["detail_table"];
                $filter = [
                    "id" => $_REQUEST["DYNAMICS_PAGE"]["detail_entry"]
                ];
                $res = $PROJECT->objects["TABLES"]->getTableArray($table, [], $filter);
                $this->arData = $res;

                $this->includeControllerView("detail-entry");
            }
        }
        
        
    } 
} 