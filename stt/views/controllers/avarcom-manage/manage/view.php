<div class="avarcom-manage">
    <div class="manage-scan-info">
        <div class="scan-info-head">
        </div>
        <form method="post">
            <input type="hidden" name="handler" value="update-all">
            <input type="submit" value="Обновить все страницы">
        </form>
        <?foreach ($arData["urlList"] as $urlList):?>
            <form method="post">
                <span>
                    <?=$urlList["url"]?>
                    <input type="hidden" name="url" value="<?=$urlList["url"]?>">
                </span>
                <?if (isset($urlList["data"]["error"])):?>
                    <span></span>
                    <input type="submit" value="Обновить сканирование">
                <?else:?>
                    <span><?=$urlList["data"]["latestUpdate"]["notifyTime"]?></span>
                    <input type="submit" value="Обновить сканирование">
                <?endif?>
                <input type="hidden" value="update" name="handler">
            </form>
        <?endforeach?>
    </div>
</div> 
<?
    echo "<pre>"; print_r($arData); echo "</pre>";
?>