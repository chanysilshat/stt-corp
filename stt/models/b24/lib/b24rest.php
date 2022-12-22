<?php
class B24Rest extends OutRest
{
    //public $url = "https://b24-ds3r6v.bitrix24.ru/rest/1/n59l10nrga7op7gn/";
    public $url = "";
  

    public $rest = array();

    
    protected function executeRest(){
        $this->rest = array(
            "calendar.resource.add" => $this->url."calendar.resource.add.json",
            "calendar.resource.delete" => $this->url."calendar.resource.delete.json",
            "calendar.resource.list" => $this->url."calendar.resource.list.json",
            "catalog.catalog.add" => $this->url."catalog.catalog.add.json",
            "catalog.catalog.delete" => $this->url."catalog.catalog.delete.json",
            "catalog.catalog.get" => $this->url."catalog.catalog.get.json",
            "catalog.catalog.getFields" => $this->url."catalog.catalog.getFields.json",
            "catalog.catalog.list" => $this->url."catalog.catalog.list.json",
            "catalog.product.add" => $this->url."catalog.product.add.json",
            "catalog.product.get" => $this->url."catalog.product.get.json",
            "catalog.product.getFieldsByFilter" => $this->url."catalog.product.getFieldsByFilter.json",
            "catalog.product.list" => $this->url."catalog.product.list.json",
            "catalog.section.list" => $this->url."catalog.section.list.json",
            "crm.catalog.list" => $this->url."crm.catalog.list.json",
            "crm.deal.add" => $this->url."crm.deal.add.json",
            "crm.deal.contact.fields" => $this->url."crm.deal.contact.fields.json",
            "crm.deal.fields" => $this->url."crm.deal.fields.json",
            "crm.deal.get" => $this->url."crm.deal.get.json",
            "crm.deal.list" => $this->url."crm.deal.list.json",
            "crm.deal.productrows.get" => $this->url."crm.deal.productrows.get.json",
            "crm.deal.productrows.set" => $this->url."crm.deal.productrows.set.json",
            "crm.deal.update" => $this->url."crm.deal.update.json",
            "crm.deal.userfield.add" => $this->url."crm.deal.userfield.add.json",
            "crm.deal.userfield.delete" => $this->url."crm.deal.userfield.delete.json",
            "crm.deal.userfield.list" => $this->url."crm.deal.userfield.list.json",
            "crm.company.add" => $this->url."crm.company.add.json",
            "crm.company.contact.fields" => $this->url."crm.company.contact.fields.json",
            "crm.company.list" => $this->url."crm.company.list.json",
            "crm.contact.add" => $this->url."crm.contact.add.json",
            "crm.contact.list" => $this->url."crm.contact.list.json",
            "crm.product.add" => $this->url."crm.product.add.json",
            "crm.product.fields" => $this->url."crm.product.fields.json",
            "crm.product.property.add" => $this->url."crm.product.property.add.json",
            "crm.product.property.delete" => $this->url."crm.product.property.delete.json",
            "crm.product.property.fields" => $this->url."crm.product.property.fields.json",
            "crm.product.property.get" => $this->url."crm.product.property.get.json",
            "crm.product.property.list" => $this->url."crm.product.property.list.json",
            "crm.product.property.types" => $this->url."crm.product.property.types.json",
            "crm.product.update" => $this->url."crm.product.update.json",
            "crm.productrow.fields" => $this->url."crm.productrow.fields.json",
            "crm.userfield.fields" => $this->url."crm.userfield.fields.json",
            "tasks.task.list" => $this->url."tasks.task.list.json",
            "tasks.task.counters.get" => $this->url."tasks.task.counters.get.json",
        );
    }
    
    public function sendRestQuery($query, $params = false){
        return $this->sendQuery($this->url.$query.".json", $params);
    }

      /**
     * Преобразовывает массив в строку в формат GET запроса
     * @return string
     */
    public function convertArrayToString($array, $PARENT_STRING){
        $string = "";
        foreach ($array as $key => $rest){
            if (is_array($rest)){
                if (empty($PARENT_STRING)){
                    $params = $PARENT_STRING.@"$key";
                } else {
                    $params = $PARENT_STRING.@"[$key]";
                }
                $string .= $this->convertArrayToString($rest, $params);      
            } else {   
                if (empty($PARENT_STRING)){
                    $string .= "&".$PARENT_STRING . @"$key=$rest";
                } else {
                    $string .= "&".$PARENT_STRING . @"[$key]=$rest";
                }
            }
        }
        if (empty($PARENT_STRING)){
            $string = substr($string, 1);
        }
        $string = str_replace(" ", "+", $string);
        return $string;
    }

    public function calendarResourceAdd($params){
        return $this->sendQuery($this->rest["calendar.resource.add"], $params);
    }

    public function calendarResourceDelete($params){
        return $this->sendQuery($this->rest["calendar.resource.delete"], $params);
    }
    
    public function calendarResourceList(){
        return $this->sendQuery($this->rest["calendar.resource.list"], false);
    }

    public function catalogCatalogAdd($params){
        $getParams = "?".$this->convertArrayToString($params, false);
        return $this->sendQuery($this->rest["catalog.catalog.add"].$getParams, false);
    }

    public function catalogCatalogDelete($params){
        $getParams = "?".$this->convertArrayToString($params, false);
        return $this->sendQuery($this->rest["catalog.catalog.delete"].$getParams, false);
    }

    public function catalogCatalogList($params){
        return $this->sendQuery($this->rest["catalog.catalog.list"], $params);
    }

    public function catalogCatalogGet($params){
        return $this->sendQuery($this->rest["catalog.catalog.get"], $params);
    }


    public function catalogCatalogGetFields(){
        return $this->sendQuery($this->rest["catalog.catalog.getFields"], false);
    }

    public function catalogProductAdd($params){
        return $this->sendQuery($this->rest["catalog.product.add"], $params);
    }

    public function catalogProductGet($params){
        return $this->sendQuery($this->rest["catalog.product.get"], $params);
    }

    public function catalogProductGetFieldsByFilter($params){ 
        return $this->sendQuery($this->rest["catalog.product.getFieldsByFilter"], $params);
    }

    public function catalogProductList($params){
        return $this->sendQuery($this->rest["catalog.product.list"].$getParams, $params);
    }

    public function catalogSectionList($params){
        return $this->sendQuery($this->rest["catalog.section.list"], $params);
    }


    public function crmCatalogList(){
        return $this->sendQuery($this->rest["crm.catalog.list"], false);
    }

    public function crmDealAdd($params){
        $getParams = "?".$this->convertArrayToString($params, false);
        return $this->sendQuery($this->rest["crm.deal.add"].$getParams, false);
    }

    /**
     * Возвращает для связи сделка-контакт описание полей, используемых методами семейства crm.deal.contact.*
     */
    public function crmDealContactFields(){
        return $this->sendQuery($this->rest["crm.deal.contact.fields"], false);
    }

     /**
     * Возвращает описание полей сделки, в том числе пользовательских.
     */

    public function crmDealFields(){
        return $this->sendQuery($this->rest["crm.deal.fields"], false);
    }

    public function crmDealGet($id){
        $getParams = "?".$this->convertArrayToString(array("ID" => $id), false);
        return $this->sendQuery($this->rest["crm.deal.get"].$getParams, false);
    }
    
    public function crmDealList($params){
        return $this->sendQuery($this->rest["crm.deal.list"], $params);
    }

    public function crmDealProductrowsGet($params){
        return $this->sendQuery($this->rest["crm.deal.productrows.get"], $params);
    }

    public function crmDealProductrowsSet($params){
        return $this->sendQuery($this->rest["crm.deal.productrows.set"], $params);
    }

    public function crmDealUpdate($params){
        return $this->sendQuery($this->rest["crm.deal.update"], $params);
    }

    public function crmDealUserfieldAdd($params){
        return $this->sendQuery($this->rest["crm.deal.userfield.add"], $params);
    }

    public function crmDealUserfieldDelete($params){
        return $this->sendQuery($this->rest["crm.deal.userfield.delete"], $params);
    }

    public function crmDealUserfieldList($params){
        return $this->sendQuery($this->rest["crm.deal.userfield.list"], $params);
    }

    public function crmCompanyAdd($params){ 
        $getParams = "?".$this->convertArrayToString($params, false);
        return $this->sendQuery($this->rest["crm.company.add"].$getParams, false);
    }

    public function crmCompanyContactFields(){ 
        return $this->sendQuery($this->rest["crm.company.contact.fields"], false);
    }

    public function crmCompanyList(){ 
       return $this->sendQuery($this->rest["crm.company.list"], false);
    }

    /**
     * Создаёт новый контакт.
     */
    public function crmContactAdd($params){ 
        $getParams = "?".$this->convertArrayToString($params, false);
        return $this->sendQuery($this->rest["crm.contact.add"].$getParams, false);
    }

    /**
     * Возвращает список контактов по фильтру.
     */
    public function crmContactList($params){ 
        return $this->sendQuery($this->rest["crm.contact.list"], $params);
    }

    public function crmProductAdd($params){ 
        return $this->sendQuery($this->rest["crm.product.add"], $params);
    }

    public function crmProductFields(){ 
        return $this->sendQuery($this->rest["crm.product.fields"], false);
    }

   

    public function crmProductPropertyAdd($params){ 
        return $this->sendQuery($this->rest["crm.product.property.add"], $params);
    }

    public function crmProductPropertyDelete($params){ 
        return $this->sendQuery($this->rest["crm.product.property.delete"], $params);
    }

    public function crmProductPropertyFields(){ 
        return $this->sendQuery($this->rest["crm.product.property.fields"], false);
    }

    public function crmProductPropertyGet($params){ 
        return $this->sendQuery($this->rest["crm.product.property.get"], $params);
    }

    public function crmProductPropertyList($params){ 
        return $this->sendQuery($this->rest["crm.product.property.list"], $params);
    }

    public function crmProductPropertyTypes($params){ 
        return $this->sendQuery($this->rest["crm.product.property.types"], $params);
    }

    public function crmProductUpdate($params){ 
        return $this->sendQuery($this->rest["crm.product.update"], $params);
    }

    public function crmProductrowFields(){ 
        return $this->sendQuery($this->rest["crm.productrow.fields"], $params);
    }

    public function crmUserfieldFields(){ 
        return $this->sendQuery($this->rest["crm.userfield.fields"], false);
    }
}
