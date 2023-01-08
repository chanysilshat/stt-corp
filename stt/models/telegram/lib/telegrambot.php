<?
class TelegramBot extends OutRest
{
    protected $token;
    public $rest;
    protected $url = "https://api.telegram.org/bot";

    protected function executeRest()
    {
        $this->rest = [
            "sendMessage" => $this->url . $this->token . '/sendMessage',
        ];
    }
} 