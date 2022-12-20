<?
class InstallDataBase extends DataBase{

    
    public function __construct()
    {   
        
    } 

    /**
     * Создаёт или же записывает в туже базу данные
     * newDB - создаёт новую или записывает в туже
     * overwrite - перезаписывает данные
     */
    public function installDB($newDB = false, $overwrite = false){

        $this->checkConnect();
        if ($this->checkConnectDataBase()){
            //$this->createTables();
        } else {
          
        } 
    }

    /**
     * Создаёт базу данных
     */
    private function createDataBase(){
       
        global $dbconnect;

        $dataBaseName = $dbconnect["database"];

        $query = "CREATE DATABASE " . $dataBaseName . " CHARACTER  SET utf8 COLLATE utf8_general_ci";
        $this->sendQuery($query);
    }

    /**
     * Возвращает действие при установке
     */
    public function getAction(){

        if ($this->checkConnect()){

            if ($this->checkConnectDataBase()){

                echo "К серверу и к БД соездинение установлено";
            } else {

                echo "Мы не смогли подключиться к БД";
    
                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                global $dbconnect;
    
                try{
                    $query = "SHOW DATABASES;";
                    $mysqli = new mysqli($dbconnect["server"], $dbconnect["login"], $dbconnect["password"]);
                    $obj = $mysqli->query($query, MYSQLI_USE_RESULT);
                    
                    while($res = $obj->fetch_assoc()){
                        if ($res["Database"] == $dbconnect["database"]){
                            //Перезапись или же добавляем данные
                        }
                    }
        
                
                    $obj->close();
                }
                catch(Exception $e){

                    echo "Ошибка выполнения запроса";
                    //return false
                }
    
            }
        } else {
            echo "Мы не смогли подключиться к серверу";
        }
    }

    public function test(){
        $i = [
            "test" => "tss",
            "adb" =>"stt"
        ]; 
        $b = [ 
            [
                1,
                2,
                "wefwer"
            ],
            [
                "qwerty"
            ]
        ];
        return ["массив Б" => $b, "Массив i" =>$i];
        

    }
    
}

?>