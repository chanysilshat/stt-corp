<?
/** @var object $PROJECT */

if (isset($_REQUEST["login"]) && isset($_REQUEST["password"])){
    $User->autorizedUser($_REQUEST["login"], $_REQUEST["password"]);
}

$settings = [];
$manage = new Manage();
$statusUser = $User->getUserStatus();
$settings["user_authorized"] = $statusUser['authorized'];
$settings["log"] = $statusUser['log'];

$settings["SESSION"] = $_SESSION;
if ($settings["user_authorized"] == "y"){
    $settings["MAIN_MENU"] = Manage::getMainAdminMenu();  
}

echo json_encode($settings);