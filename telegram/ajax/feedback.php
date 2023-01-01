<?php


$token = "5604356654:AAHzR3JQIVIGju_lf_zgyRpfcubTyou15ww";
$chat_id = "893447768";

// сюда нужно вписать токен вашего бота
define('TELEGRAM_TOKEN', $token);

// сюда нужно вписать ваш внутренний айдишник
define('TELEGRAM_CHATID', $chat_id);

function message_to_telegram($text)
{
    $dir = $_SERVER["DOCUMENT_ROOT"] . "/telegram/bot/chats";
    $chats = dirToArray($dir);

    foreach ($chats as $chatID){
        $ch = curl_init();
        curl_setopt_array(
            $ch,
            array(
                CURLOPT_URL => 'https://api.telegram.org/bot' . TELEGRAM_TOKEN . '/sendMessage',
                CURLOPT_POST => TRUE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_POSTFIELDS => array(
                    //'chat_id' => TELEGRAM_CHATID,
                    'chat_id' => $chatID,
                    'parse_mode' => "html",
                    'text' => $text,
                ),
            )
        );
        curl_exec($ch);
    }
  
}

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

if (isset($_REQUEST["name"]) && isset($_REQUEST["phone"])){
    $info = "<br>Имя: " . $_REQUEST["name"] . " <br> Телефон " . $_REQUEST["phone"] ;

    $text = 'Сообщение формы от '. date("d.m.Y H:i:s") . ' ' . $info;
    
    $text = str_replace("<br>", " \n", $text);
    
    message_to_telegram($text);
}

if (isset($_REQUEST["phoneClick"]) && $_REQUEST["phoneClick"] == "click"){
    $text = "Произошло нажатие на кнопку звонка! \n ID Яндекс клиента: " . $_REQUEST["yandexID"] . " \n " . $_REQUEST["HTTP_REFERER"] . "\n" .  $_REQUEST["HTTP_SEC_CH_UA"] . "\n" .  $_REQUEST["REMOTE_ADDR"] . "\n" .  $_REQUEST["url"];
    message_to_telegram($text);
}

?>

<div class="result">
    <h2>
        Спасибо за заявку. Скоро будем
    </h2>
</div>