<?
class UpdateRest extends OutRest
{
    protected $token;
    protected $url = "https://stt-corp.ru/updates";

    protected function executeRest()
    {
        $this->rest = [
            "get.modules.info" => $this->url . '/get.modules.info/',
            "get.text.update.file" => $this->url . '/get.text.update.file/',
        ];
    }
}