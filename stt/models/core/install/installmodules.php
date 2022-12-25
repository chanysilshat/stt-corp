<?
/**
 * Поиск модулей
 * Запуск устанощика
 * 
 * 
 */
class InstallModules{

    public $errors = [];

    private $DataBase;

    public function __construct()
    {   
    } 

    //Получает список дочерних классов
    public function installModules(){

        global $User;

        $this->getModules();

        $tablesDB = $this->getTables();
        foreach ($tablesDB as $table){
            $this->dropTable($table);
        }

        foreach( get_declared_classes() as $class ){
            if(is_subclass_of( $class, 'Install') ){
                $children[] = $class;             
            }
        }

        
        
        sleep(2);

   
        $tablesDB = $this->getTables();
        //Процесс создания таблиц модулей
        foreach ($children as $class){
            $ch_class = new $class();
            $moduleTables = $ch_class->getTables();
            $ch_class->setDataBaseObject($this->DataBase);
            foreach ($tablesDB as $table){
                if (isset($moduleTables[$table])){
                    unset($moduleTables[$table]);
                }

            }
            
            $ch_class->beforeCreateTables();

            foreach ($moduleTables as $tableName => $fields){
                $ch_class->beforeCreateTable();
                $ch_class->createTable($tableName, $fields);
                $ch_class->afterCreateTable();
            }

            $ch_class->afterCreateTables();

            unset($ch_class);
        }

        
        foreach ($children as $class){

            $ch_class = new $class();

            $ch_class->beforeSetDefaultValues();

            $ch_class->setDataBaseObject($this->DataBase);
            $ch_class->setDefaultValues();

            $ch_class->afterSetDefaultValues();
        }

        foreach ($children as $class){
            $ch_class = new $class();
            $ch_class->setDataBaseObject($this->DataBase);
            $ch_class->createConnectionFromTables();
            unset($ch_class);
        }
       
    }


    //Устанавливает объект DataBase
    public function setDataBaseObject($object){
        $this->DataBase = $object;
    }

    //Получает список модулей
    public function getModules(){

        $dir = opendir($_SERVER["DOCUMENT_ROOT"] . '/stt/models/');
        while($module = readdir($dir)) {

            if (is_dir('stt/models/'.$module) && $module != '.' && $module != '..') {
                $fullFileName =  $_SERVER["DOCUMENT_ROOT"] . '/stt/models/' . $module . '/install/install' . $module . '.php';
                
                if (file_exists($fullFileName)){
                    require_once $fullFileName;
                }
            }
        }
    }

    private function getTables(){

        $query = "SHOW TABLES FROM " . $this->DataBase->dbconnect["database"];
        $res = $this->DataBase->sendQuery($query);
        foreach ($res as $items){
            foreach ($items as $table){
                $result[] = $table;
            }
        }
        return $result;
    }
    
    public function dropTable($tableName){

        $query = "SELECT * FROM information_schema.KEY_COLUMN_USAGE Where REFERENCED_TABLE_NAME ='" . $tableName . "'";

        $res = $this->DataBase->sendQueryDB($query);

        
        if (!empty($res) && is_array($res)){
            foreach ($res as $foregin){
                $query = "ALTER TABLE `" . $foregin["TABLE_NAME"] . "` DROP FOREIGN KEY `" . $foregin["CONSTRAINT_NAME"] . "`;";
                $res = $this->DataBase->sendQueryDB($query);
            }
        }

        $query = "DROP TABLE " . $tableName ;
        $result = $this->DataBase->sendQueryDB($query);

        return $result;
    }

}

?> 