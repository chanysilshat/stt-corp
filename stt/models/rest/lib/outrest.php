<? 
class OutRest
{
    protected $table;
    protected $token;
    protected $url;
    protected $method;
    protected $rest;

    public function __construct()
    { 
        
    }

    protected function executeRest()
    {
       
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }
    /**
     * Отправляет Rest запрос
     */
    public function executeMethod($method, $data)
    {
        $this->executeRest();
        if (isset($this->rest[$method])){
            return $this->sendQuery($this->rest[$method], $data);
        } else {
            return ["ERROR" => "Method not found"];
        }
    }

    protected function sendQuery($url, $data)
    {

        $Cnct = curl_init(); // инициализация cURL подключения
        curl_setopt($Cnct, CURLOPT_URL, $url); // адрес запроса

        if ($data){
            curl_setopt($Cnct, CURLOPT_POST, true);
            curl_setopt($Cnct, CURLOPT_POSTFIELDS, http_build_query($data));
        }

        curl_setopt($Cnct, CURLOPT_RETURNTRANSFER, 1); // просим вернуть результат
        $response = curl_exec($Cnct); // получаем и декодируем данные из JSON
        $response = json_decode($response, true);
        curl_close($Cnct); // закрываем соединение
        return $response;
    }
}