<?
$data = $arData;
foreach ($data["DATA"] as $key => $dataItem){
    foreach ($dataItem["ITEMS"] as $value){
        if (isset($poins[$key][$value["X_VALUE"]])){
            if ($value["Y_VALUE"] > $poins[$key][$value["X_VALUE"]]){
                $poins[$key][$value["X_VALUE"]] = $value["Y_VALUE"];
                $info[$key][$value["X_VALUE"]] = $value["INFO"];
            }

        } else {
            $poins[$key][$value["X_VALUE"]] = $value["Y_VALUE"];
            $info[$key][$value["X_VALUE"]] = $value["INFO"];
        }
    }
    ksort($poins[$key]);
    ksort($info[$key]);
}
$pointSTR = [];
$circle = [];
foreach ($poins as $key => $point){
    foreach ($point as $vKey => $value){
        if ($data["X_LABEL"]["TYPE"] == "DATE"){
            $x = ((strtotime($vKey) - $data["X_LABEL"]["MIN"]) / $data["WIDTH"]) / (($data["X_LABEL"]["MAX"] - $data["X_LABEL"]["MIN"]) / $data["WIDTH"]) * $data["WIDTH"] + 90;
            $y = $data["HEIGHT"] - $value / ($data["Y_LABEL"]["MAX"] - $data["Y_LABEL"]["MIN"]) * $data["HEIGHT"];
            $pointSTR[$key] .= $x . "," . $y . " ";
            $circle[$key][$vKey] = [
                "x" => $x,
                "y" => $y,
                "INFO" => $info[$key][$vKey]
            ];
            
        }
    }
    
}
?>

<div avarcom-svg-stat="test">
    <svg version="1.2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="graph" aria-labelledby="title" role="img">
  
    <g class="grid x-grid" id="xGrid">
        <line x1="90" x2="90" y1="5" y2="<?=$data["HEIGHT"]?>"></line>
    </g>
    <g class="grid y-grid" id="yGrid">
        <line x1="90" x2="<?=$data["WIDTH"] + 90?>" y1="<?=$data["HEIGHT"]?>" y2="<?=$data["HEIGHT"]?>"></line>
    </g>
    <g class="labels x-labels">
        <?for ($i = 0; $i <= $data["X_LABEL"]["COUNT"]; $i++):?>
            <text x="<?=intval(90 + (($data["WIDTH"] - 10) / $data["X_LABEL"]["COUNT"] * $i))?>" y="<?=$data["HEIGHT"] + 30?>">
                <?if ($data["X_LABEL"]["TYPE"] == "DATE"):?>
                    <?=date($data["X_DATE_FORMAT"] , ($data["X_LABEL"]["MIN"] + intval(($data["X_LABEL"]["MAX"] - $data["X_LABEL"]["MIN"]) / $data["X_LABEL"]["COUNT"] * $i)))?>
                <?else:?>
                    <?=$data["X_LABEL"]["MIN"] + intval(($data["X_LABEL"]["MAX"] - $data["X_LABEL"]["MIN"]) / $data["X_LABEL"]["COUNT"] * $i)?>
                <?endif?>
            </text>
        <?endfor?>
        <text x="<?=intval($data["WIDTH"] / 2)?>" y="<?=$data["HEIGHT"] + 60?>" class="label-title"><?=$data["X_LABEL_TITLE"]?></text>
    </g>
    <g class="labels y-labels">
        <?for ($i = 0; $i <= $data["Y_LABEL"]["COUNT"]; $i++):?>
            <text x="80" y="<?=intval($data["HEIGHT"] - (($data["HEIGHT"] - 10) / $data["Y_LABEL"]["COUNT"] * $i))?>">
                <?if ($data["Y_LABEL"]["TYPE"] == "DATE"):?>
                    <?=date($data["Y_DATE_FORMAT"], ($data["Y_LABEL"]["MIN"] + intval(($data["Y_LABEL"]["MAX"] - $data["Y_LABEL"]["MIN"]) / $data["Y_LABEL"]["COUNT"] * $i)))?>
                <?else:?>
                    <?=$data["Y_LABEL"]["MIN"] + intval(($data["Y_LABEL"]["MAX"] - $data["Y_LABEL"]["MIN"]) / $data["Y_LABEL"]["COUNT"] * $i)?>
                <?endif?>
            </text>
        <?endfor?>
        <text x="90" y="<?=intval($data["HEIGHT"] / 2)?>" class="label-title"><?=$data["Y_LABEL_TITLE"]?></text>
    </g>
    <g class="data" data-setname="Our first data set">
        <?foreach ($pointSTR as $key => $point):?>
            <polyline
            fill="none"
            stroke="<?=$data["DATA"][$key]["COLOR"]?>"
            stroke-width="3"
            points="<?=$point?>"/>
            <?foreach ($circle[$key] as $item):?>
                <g>
                    <circle cx="<?=$item["x"]?>" cy="<?=$item["y"]?>" r="4" stroke="black" stroke-width="3" fill="red" />
                    <foreignObject class="svg-info" x="<?=$item["x"]?>" y="<?=$item["y"]?>" width="160" height="160">
                        <div xmlns="http://www.w3.org/1999/xhtml">
                            <?=$item["INFO"]?>
                        </div>
                    </foreignObject>
                </g>
            <?endforeach?>
        <?endforeach?>
    </g>
  </svg>
</div>

