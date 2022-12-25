<?
class STTConfig
{
    private $DataBaseObject;
    private $TablesObject;
    private $table = "stt_configs";

    public function __construct()
    {

    }

    public function setDataBaseObject($object)
    {
        $this->DataBaseObject = $object;
    }

    public function setTablesObject($tablesObject)
    {
        $this->TablesObject = $tablesObject;
    }

    public function getConfigValue($config, $module)
    {
        return $this->getValue($config, $module);
    }

    private function getValue($config, $module)
    {
        $filter = [
            "config_code" => $config,
            "module_code" => $module
        ];

        $res = $this->TablesObject->getList($this->table, [], $filter);

        if ($res){
            return $res[0];
        }

    }
}