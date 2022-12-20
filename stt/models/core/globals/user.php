<?
/**
 * Управляет над проектом
 */
    final class User
    {
        private $userTable = "stt_users";
        private $userID;
        private $groupID;
        private $userHash;
        private $userPassword; 
        private $userLogin;
        private $userEmail;
        private $userGroupCode;
        private $userAutorized;
        private $userStatus;
        private $DataBaseObject;
        private $TablesObject;

        public function __construct(){
            $this->userStatus = [
                "authorized" => "n",
            ];
        }   
        
        public function setDataBaseObject($object){
            $this->DataBaseObject = $object;
        }

        public function setTablesObject($object){
            $this->TablesObject = $object;
        }

        public function isAutorized(){
            return $this->userAutorized;
        } 

        private function updatePassword(){

        }

        public function registerUser($login, $password){

            $userLogin = $login;
            $userPassword = $password;

            $hash = $userLogin . $userPassword;

            $crypter = new Crypter($hash);
            $hashKey = $crypter->encrypt($hash);

            $crypter = new Crypter($hashKey);

            $loginHash = $crypter->encrypt($userLogin);
            $passwordHash = $crypter->encrypt($userPassword);

            $hash = $loginHash . " " . $passwordHash;
            $hash = $crypter->encrypt($hash);

            $select = [
                "id", 
                "login",
                "hash"
            ];

            $filter = [
                "login" => $loginHash
            ];
            $res = $this->TablesObject->getList($this->userTable, $select, $filter);
            if (empty($res)){
                $fields = [
                    "login" => $loginHash,
                    "password" => $passwordHash,
                    "hash" => $hashKey,
                ];
                $this->TablesObject->insertIntoTable($this->userTable, $fields);
            }
        }

          /**
         * Логин + пароль = ключ для хеша 
         * Хешируем ключ хеша
         * Хешированный ключ отправляем в виде ключа хеша
         * Хешируем логин
         * Хешируем пароль
         * Хешируем хешированный логин и хешированный пароль = пользовательский хеш
         * Хешируем пользовательский хеш
         */
        public function autorizedUser($login, $password){

            $userLogin = $login;
            $userPassword = $password;

            $hash = $userLogin . $userPassword;

            $crypter = new Crypter($hash);
            $hashKey = $crypter->encrypt($hash);

            $crypter = new Crypter($hashKey);

            $loginHash = $crypter->encrypt($userLogin);

            $passwordHash = $crypter->encrypt($userPassword);

            $select = [
                "id", 
                "login",
                "hash"
            ];

            $filter = [
                "login" => $loginHash,
                "password" => $passwordHash
            ];

            $res = $this->TablesObject->getList($this->userTable, $select, $filter);
            if (empty($res)){
                return false;
            } else {
                $hash = $loginHash . " " . $passwordHash;
                $hash = $crypter->encrypt($hash);
                Session::setSession("USER_HASH", $hash);
                Session::setSession("USER_SESS_ID", $hashKey);  
                $this->userStatus = [
                    "authorized" => "y",
                ];
            }
        }
      

        public function getUserStatus(){

            if (!empty($_SESSION["USER_SESS_ID"]) && !empty($_SESSION["USER_HASH"])){
                $crypter = new Crypter($_SESSION["USER_SESS_ID"]);
                $deHash = $crypter->decrypt($_SESSION["USER_HASH"]);
                $deHashArr = explode(" ", $deHash);

                $select = [
                    "login", 
                    "password",
                    "hash"
                ];
                $filter = [
                    "login" => $deHashArr["0"],
                    "password" => $deHashArr["1"],
                    "hash" => $_SESSION["USER_SESS_ID"]
                ];
                $res = $this->TablesObject->getList($this->userTable, $select, $filter);
                if (!empty($res)){
                    $this->userStatus = [
                        "authorized" => "y",
                    ];

                    $hash = $res[0]["login"] . " " . $res[0]["password"];

                    $hash = $crypter->encrypt($hash);
                    
                    Session::setSession("USER_HASH", $hash);
                    Session::setSession("USER_SESS_ID", $_SESSION["USER_SESS_ID"]); 
                } else {
                    Session::removeSession("USER_HASH");
                    Session::removeSession("USER_SESS_ID");
                    $this->userStatus = [
                        "authorized" => "n",
                    ];
                }
            } else {
                $this->userStatus = [
                    "authorized" => "n",
                ];
            }

            return $this->userStatus;
        }
    }
