<?

class Install{

    protected $DataBaseObject;

    protected $tables = [];
    protected $connectionsFromTables = [];
    protected $moduleName = "";
    protected $defaultValues = [];

    public function __construct(){

    }

    public function beforeCreateTables(){}

    public function beforeCreateTable(){}

    public function afterCreateTable(){}

    public function afterCreateTables(){}

    public function beforeSetDefaultValues(){}

    public function afterSetDefaultValues(){}

    public function getTables(){
        return $this->tables;
    }

    public function createTable($tableName, $arFields){
        
        $query = "CREATE TABLE `". $tableName . "` (";
        foreach ($arFields as $name => $type){
            $query .= @"$name $type, ";
        }

        $query = substr($query, 0, -2);

        $query .= ");";
        
        $result = $this->DataBaseObject->sendQueryDB($query);
        return $result;
    }

    public function dropTable($tableName){
        $query = "DROP TABLE " . $tableName;
        $result = $this->DataBaseObject->sendQueryDB($query);
        return $result;
    }

    public function setDataBaseObject($object){
        $this->DataBaseObject = $object;
    }

    
    public function createConnectionFromTables(){
            
        foreach ($this->connectionsFromTables as $connectionsFromTables){
            $query = @"ALTER TABLE `".$connectionsFromTables["INSIDE"]["TABLE"]."` ADD FOREIGN KEY (`".$connectionsFromTables["INSIDE"]["KEY"]."`) REFERENCES `".$connectionsFromTables["FORIGEN"]["TABLE"]."`(`".$connectionsFromTables["FORIGEN"]["KEY"]."`) ON DELETE CASCADE ON UPDATE CASCADE;";
            //$query = @"ALTER TABLE `".$connectionsFromTables["INSIDE"]["TABLE"]."` ADD FOREIGN KEY (`".$connectionsFromTables["INSIDE"]["KEY"]."`) REFERENCES `".$connectionsFromTables["FORIGEN"]["TABLE"]."`(`".$connectionsFromTables["FORIGEN"]["KEY"]."`);";
            $result = $this->DataBaseObject->sendQueryDB($query);
        }
    }

    public function setDefaultValues(){
        if (!empty($this->defaultValues)){
            foreach ($this->defaultValues as $table => $items){
                foreach ($items as $key => $default){
                    $this->insertIntoTable($table, $default);
                }
            }
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

}
