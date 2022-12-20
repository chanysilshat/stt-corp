<?
if (isset($_REQUEST["DYNAMICS_PAGE"]["module_code"])){

    $models = $_REQUEST["DYNAMICS_PAGE"]["module_code"];
    $fileFullName = $_SERVER["DOCUMENT_ROOT"] . '/stt/models/'.$models.'/panel/index.php';

    if (file_exists($fileFullName)){
        require_once $fileFullName;
    }
    
} else {

$dir = opendir($_SERVER["DOCUMENT_ROOT"] . '/stt/models/');

$modelsList = [];

while($models = readdir($dir)){
    if (is_dir('stt/models/'.$models.'/panel/') && $models != '.' && $models != '..') {

        $fileFullName = $_SERVER["DOCUMENT_ROOT"] . '/stt/models/'.$models.'/panel/index.php';

        if (file_exists($fileFullName)){
            $PROJECT::includeModules($models);

            foreach( get_declared_classes() as $class ){
                if(is_subclass_of( $class, 'Module') ){
                    $ch_class = new $class();  
                    if ($ch_class->getModuleName() == $models){
                        $modelsList[] = [
                            "module_name" => $ch_class->getModuleName(),
                            "module_title" => $ch_class->getModuleTitle(),
                        ];
                    }
                }
            }

        }
    }
}

echo "<pre>"; print_r($_REQUEST); echo "</pre>";
foreach ($modelsList as $module):?>
    <div class="module-item">
        <a stt-admin href="/admin/modules/<?=$module["module_name"]?>/"><?=$module["module_title"]?></a>
    </div>
<?endforeach?>

<?}?>
