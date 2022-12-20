<?

final class Session
{
    public $sessionArray;
    
    public function __construct(){
        global $_SESSION;
        session_start();
        $this->sessionArray = $_SESSION;
    }

    public function startSession(){
   
    }

    public function setSessionValues($key, $value){
        $this->sessionArray[$key] = $value; 
        $this->updateSession();
    }

    public function removeSessionValue($key){
        global $_SESSION;
        unset($this->sessionArray[$key]);
        $this->updateSession();
    }

    private function updateSession(){
        global $_SESSION;
        $_SESSION = $this->sessionArray;
    }
    public function endSession(){
        session_destroy();
        unset($_SESSION);
    }

    public static function setSession($key, $value){
        global $PROJECT;
        $PROJECT->setSessionValues($key, $value);


    }
    public static function removeSession($key){
        global $PROJECT;
        $PROJECT->removeSessionValue($key);

    }
}