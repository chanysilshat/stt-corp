<?
    class Tables
    {

        public $foregin = [];
        public $informationSchema = [];
        public $keyColumnUsage = [];
        public $DataBaseObject;

        public function __construct()
        {   
            
        } 

        public function getTableArray($table, $select = [], $filter = []){
            $data = $this->getList($table, $select, $filter);
            $informationSchema = $this->getInformationSchema($table);
            $keyColumnUsage = $this->getKeyColumnUsage($table);
            $foreginData = [];
            foreach ($keyColumnUsage as $column){
                if (isset($informationSchema[$column["COLUMN_NAME"]])){
                    if (!empty($column["REFERENCED_TABLE_NAME"])){
                        $foregin[$column["REFERENCED_TABLE_NAME"]]["column"] = $column["REFERENCED_COLUMN_NAME"];
                        $foreginData[$column["REFERENCED_TABLE_NAME"]] = $this->getList($column["REFERENCED_TABLE_NAME"], [], []);
                    }
                }
            }
            $foregin = $this->getForegin();
            $result["columns"] = $informationSchema;
            $result["foregin"] = $foregin;
            $result["data"] = $data;
            $result["foreginData"] = $foreginData;
            return $result;

        }
        
        public function getList($table, $select, $filter){

            if (!empty($table)){
                $query = @"SELECT COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table'";
                $property = $this->DataBaseObject->sendQueryDB($query);
                
                $columns = [];
                foreach ($property as $column){
                    $columns[$column["COLUMN_NAME"]] = $column["DATA_TYPE"];
                }

                $strSelect = "";
                if (is_array($select)){
                    if (count($select) > 0){
                        foreach ($select as $item){
                            if (!empty($columns[$item])){
                                $strSelect .= $item.", ";
                            }
                        }
                        $strSelect = substr($strSelect, 0, -2);
                    } else {
                        $strSelect = "*";
                    }
                } else {
                    $strSelect = "*"; 
                }

                $strWhere = "";
                $keys = "";
                $where = "";
                if (is_array($filter)){
                    if (count($filter) > 0){
                       
                        foreach ($filter as $key => $item){

                            if (!empty($columns[$key])){
                                //$keys .= @"$key, ";

                                $keys = array_keys($filter);

                                if ($columns[$key] == "int"){
                                    if (is_array($item)){

                                        foreach ($item as $index => $arrayField){
                                            if ($index == 0){
                                                if ($key == $keys[0]){
                                                    $strWhere .= @"$key=$arrayField";
                                                } else {
                                                    $strWhere .= @" or $key=$arrayField";
                                                } 
                                            } else {
                                                $strWhere .= @" or $key=$arrayField";
                                            }
                                        }
                                    } else {
                                        if ($key == $keys[0]){
                                            $strWhere .= @"$key=$item";
                                        } else {
                                            $strWhere .= @" AND $key=$item";
                                        } 
                                    }
                                   
                                } else {
                                    if (is_array($item)){
                                        foreach ($item as $index => $arrayField){
                                            if ($index == 0){
                                                if ($key == $keys[0]){
                                                    $strWhere .= @"$key='$arrayField'";
                                                } else {
                                                    $strWhere .= @" or $key='$arrayField'";
                                                } 
                                            } else {
                                                $strWhere .= @" or $key='$arrayField'";
                                            }
                                        }
                                    } else {
                                        if ($key == $keys[0]){
                                            $strWhere .= @"$key='$item'";
                                        } else {
                                            $strWhere .= @" AND $key='$item'";
                                        }
                                    } 
                                }
                            }
                        }
                        if (strlen($strWhere) > 0){
                            $where = " WHERE " . $strWhere;
                        }
                    }
                }
                $query = @"SELECT $strSelect FROM $table $where";
                $result = $this->DataBaseObject->sendQueryDB($query);

                if (empty($select) && empty($filter)){
                    if (!empty($result) && count($result) > 0){
                        file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/stt/json/database/" . $table . ".json", json_encode($result));
                    }
                }

                return $result;
            } 
        }

        public function insertIntoTable($table, $arFields){

            $query = @"SELECT COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table'";
            $property = $this->DataBaseObject->sendQueryDB($query);
            
            $columns = [];
            foreach ($property as $column){
                $columns[$column["COLUMN_NAME"]] = $column["DATA_TYPE"];
            }

            $query = @"INSERT INTO `$table` ";

            $keys = "(";
            $values = "(";
            foreach ($arFields as $key => $value){
                if (!empty($value)){
                    if (!empty($columns[$key])){
                        $keys .= @"$key, ";
                        if ($columns[$key] == "int" || $columns[$key] == "tinyint" || $columns[$key] == "smallint" || $columns[$key] == "double"){
                            $values .= @"$value, ";
                        } else {
                            $value = str_replace("'", '"', $value);
                            $values .= @"'$value', ";
                        }
                    }
                }
                
            }
            $keys = substr($keys, 0, -2);
            $values = substr($values, 0, -2);
            $keys .= ")";
            $values .= ")";
            $query .= @"$keys VALUES $values";
            $result = $this->DataBaseObject->sendQueryDB($query);
            return $result;
        }
 
        public function updateTableByID($table, $values, $where){
            
            $result = false;

            $query = @"SELECT COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table'";
            $property = $this->DataBaseObject->sendQueryDB($query);
            
            $columns = [];
            foreach ($property as $column){
                $columns[$column["COLUMN_NAME"]] = $column["DATA_TYPE"];
            }

            $query = @"UPDATE $table SET ";
            $set = "";
            foreach ($values as $key => $value){
                if (!empty($columns[$key])){
                    if ($columns[$key] == "int"){
                        $set .= @" $key=$value,";
                    } else {
                        $set .= @" $key='$value',";
                    }
                }
            }
            $set = substr($set, 0, -1);

            $query .= $set;

            $query .= @" WHERE id=$where";
            $result = $this->DataBaseObject->sendQueryDB($query, false, false);
            
            return $result;
        }
    
        public function deleteFromTable($table, $where){
            $query = @"DELETE FROM $table WHERE $where";
            $result = $this->DataBaseObject->sendQueryDB($query, false, false);
        }

        public function getKeyColumnUsage($table){
            $query = @"SELECT * FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_NAME = '$table'";
            $result = $this->DataBaseObject->sendQueryDB($query);
            $this->keyColumnUsage = $result;
            return $result;
        }

        public function getForegin(){
            foreach ($this->keyColumnUsage as $column){
                if (isset($this->informationSchema[$column["COLUMN_NAME"]])){
                    if (!empty($column["REFERENCED_TABLE_NAME"])){
                        $this->foregin[$column["REFERENCED_TABLE_NAME"]]["reference_column"] = $column["REFERENCED_COLUMN_NAME"];
                        $this->foregin[$column["REFERENCED_TABLE_NAME"]]["column"] = $column["COLUMN_NAME"];
                    }
                }
            }
            return $this->foregin;
        }

        public function getInformationSchema($table){
            $query = @"SELECT COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table' ORDER BY `COLUMNS`.`ORDINAL_POSITION` ASC";
            $property = $this->DataBaseObject->sendQueryDB($query);

            $columns = [];
            foreach ($property as $column){
                $columns[$column["COLUMN_NAME"]] = $column["DATA_TYPE"];
            }
            $this->informationSchema = $columns;

            return $columns;
        }

        public function getTables(){

            $query = "SHOW TABLES FROM " . $this->DataBaseObject->dbconnect["database"];
            $res = $this->DataBaseObject->sendQueryDB($query);
            foreach ($res as $items){
                foreach ($items as $table){
                    $result[] = $table;
                }
            }
            return $result;
        }

        public function setDataBaseObject($object){
            $this->DataBaseObject = $object;
        }

    }