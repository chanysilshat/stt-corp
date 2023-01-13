<a href="add/">Добавить новую запись</a>
<table class="stt-table" table-code="<?=$_REQUEST["DYNAMICS_PAGE"]["detail_table"]?>">
    <tr>
        <?foreach ($arData["columns"] as $key => $head):?>
            <th>
                <?=$key?>
            </th>
        <?endforeach?>
    </tr>
    <?foreach ($arData["data"] as $key => $head):?>
        <tr entry-id="<?=$head["id"]?>">
            <?foreach ($arData["columns"] as $fKey => $column):?>
                <td>
                    <?if ($fKey == "id"):?>
                        <a stt-admin href="<?=$arData["DETAIL_URL"][$key]?>"><?=$head[$fKey]?></a>
                    <?else:?>
                        <?=$head[$fKey]?>
                    <?endif?>
                </td>
            <?endforeach?>
        </tr>
    <?endforeach?>
</table>
_______________
