<?php



$data = json_decode(file_get_contents('php://input'), TRUE);
file_put_contents("data.txt", print_r($data, true));


$chatID = $data["message"]["chat"]["id"];


$data = $data['callback_query'] ? $data['callback_query'] : $data['message'];

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



define('TOKEN', "5604356654:AAHzR3JQIVIGju_lf_zgyRpfcubTyou15ww");

$message = mb_strtolower(($data['text'] ? $data['text'] : $data['data']),'utf-8');


switch ($message) {
    case 'подписаться на заявки':
        file_put_contents(__DIR__ . "/chats/" . $chatID, $chatID);

        $method = 'sendMessage';
        $send_data = [
            'text' => 'Вам будут приходить заявки!',
        ];
    break;
    case 'отписаться от заявок':
        unlink(__DIR__ . "/chats/" . $chatID);
        $method = 'sendMessage';
        $send_data = ['text' => 'Вы не подписались на заявки'];
    break;
 
    default:
        $method = 'sendMessage';
        $send_data = [
            'text' => 'Подписаться на заявки?',
            'reply_markup'  => [
                'resize_keyboard' => true,
                'keyboard' => [
                    [
                        ['text' => 'Подписаться на заявки'],
                        ['text' => 'Отписаться от заявок'],
                    ]
                ]
            ]
        ];
}

$send_data['chat_id'] = $data['chat'] ['id'];

$res = sendTelegram($method, $send_data);




function sendTelegram($method, $data, $headers = [])
{
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'https://api.telegram.org/bot' . TOKEN . '/' . $method,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array_merge(array("Content-Type: application/json"))
    ]);
    $result = curl_exec($curl);
    curl_close($curl);
    return (json_decode($result, 1) ? json_decode($result, 1) : $result);
}

?>