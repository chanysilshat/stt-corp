<?
class DataBase{

    public $dbconnect;

    public function __construct()
    {    
        
    }

    public function checkConnectToServer(){

    }
    
    /**
     * Проверяет на возможность подключения mySql
     */
    public function checkConnect(){
        global $dbconnect;

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try{
            $connect = mysqli_connect($dbconnect["server"], $dbconnect["login"], $dbconnect["password"]); 

            if (mysqli_connect($dbconnect["server"], $dbconnect["login"], $dbconnect["password"])){
                mysqli_close($connect);
                return true;
            }

        } catch (Exception $e){

            die("Невозможно подключиться к серверу БД");

        }
       
    }

    /**
     * Проверяет на возможность подключения к БД
     */
    public function checkConnectDataBase(){
        global $dbconnect;

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try{
            $connect = mysqli_connect($dbconnect["server"], $dbconnect["login"], $dbconnect["password"], $dbconnect["database"]);

            if ($connect){
                mysqli_close($connect);

                return true;
            }
            return false;

        } catch (Exception $e){

            return false;
        }
       
    }
    
    public function sendQuery($query){
          
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try{
            $mysqli = new mysqli($this->dbconnect["server"], $this->dbconnect["login"], $this->dbconnect["password"]);
            $obj = $mysqli->query($query, MYSQLI_USE_RESULT);
            
            if (is_object($obj)){
                while($res = $obj->fetch_assoc()){
                    $result[] = $res;
                }
                $obj->close();
            } else {
                $result = $obj;
            }   
        }
        catch(Exception $e){
            echo ("<br>ERROR T-SQL query: " . $query);
        }
        return $result;
    }

    public function sendQueryDB($query){
          
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try{
            $mysqli = new mysqli($this->dbconnect["server"], $this->dbconnect["login"], $this->dbconnect["password"], $this->dbconnect["database"]);
            $obj = $mysqli->query($query, MYSQLI_USE_RESULT);
            
            if (is_object($obj)){
                while($res = $obj->fetch_assoc()){
                    $result[] = $res;
                }
                $obj->close();
 
            } else {
                $result = $obj;
            }   
        }
        catch(Exception $e){
            echo ("<br>ERROR T-SQL query: " . $query . " " . $mysqli->error);
        }
        return $result;
    }

    public function setConnectConfig($dbconnect){
        $this->dbconnect = $dbconnect;
    }
    
    
}

?>