<? 

function dirToArray($dir) {
  
    $result = array();
 
    $cdir = scandir($dir);
    foreach ($cdir as $key => $value)
    {
        if (!in_array($value,array(".","..")))
        {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
            {
                $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
            }
            else
            {
                $result[] = $value;
            }
        }
    }
   
    return $result;
}

global $PROJECT;
$PROJECT::includeModules("rest");
$RestModule = new RestModule();
$OutRest = new OutRest();

$PROJECT::includeModules("telegram");

$TelegramModule = new TelegramModule();
$TelegramBot = new TelegramBot(); 
$TelegramBot->setUrl("https://api.telegram.org/bot");
$TelegramBot->setToken("5604356654:AAHzR3JQIVIGju_lf_zgyRpfcubTyou15ww");

$dir = $_SERVER["DOCUMENT_ROOT"] . "/telegram/bot/chats";
$chats = dirToArray($dir);
$text = 'Тестирование модуля';
foreach ($chats as $chatID){
    $data = [
        'chat_id' => $chatID,
        'parse_mode' => "html",
        'text' => $text,
    ];
    //$res = $TelegramBot->executeMethod("sendMessage", $data);
    echo "<pre>"; print_r($res); echo "</pre>";
}