<?foreach ($arData["AVARCOM"]["data"] as $data):?>
    <?if ($_REQUEST["DYNAMICS_PAGE"]["city"] != $data["city_code"]):?>
        <a href="/<?=$data["city_code"]?>/">
            <div class="">
                <?=$data["city"]?>
            </div>
        </a>
    <?endif?>
<?endforeach?>
