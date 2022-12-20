
<table class="stt-table" stt-table>
    <tr>
        <?foreach ($arData["COL_NAME"] as $key => $head):?>
            <th>
                <?=$head?>
            </th>
        <?endforeach?>
    </tr>
    <?foreach ($arData["ROW"] as $key => $head):?>
        <tr>
            <?foreach ($head["FIELDS"] as $column):?>
                <td>
                    <a stt-admin href="<?=$head["DETAIL_URL"]?>"><?=$column?></a>
                </td>
            <?endforeach?>
        </tr>
    <?endforeach?>
</table>
