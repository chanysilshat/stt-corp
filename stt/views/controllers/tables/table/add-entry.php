<form stt-table-form method="post">
    <?foreach ($arData["columns"] as $field => $data):?>
        <div class="form-item">
            <div class="item-name">
                <?=$field?>
            </div>
            <div class="item-form-element">
                <?if (isset($arData["foregin"][$field])):?>
                    <select name="table-handler[data][<?=$field?>]">
                        <?foreach ($arData["foreginData"][$arData["foregin"][$field]["table"]] as $foregin):?>
                            <option value="<?=$foregin[$arData["foregin"][$field]["reference_column"]]?>">
                                <?=$foregin[$arData["foregin"][$field]["reference_column"]]?>
                            </option>
                        <?endforeach?>
                    </select>
                <?else:?>
                    <input type="text" name="table-handler[data][<?=$field?>]">
                <?endif?>
            </div>
        </div>
    <?endforeach?>
    <input type="submit" class="stt-table-btn" value="Добавить запись">
    <input type="hidden" name="table-handler[handler]" value="add">
    <input type="hidden" name="table-handler[table]" value="<?=$_REQUEST["DYNAMICS_PAGE"]["detail_table"]?>">
</form>
<?
    echo "<pre>"; print_r($arData); echo "</pre>";
?>
