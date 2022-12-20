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
    $menu = [
        [
            'LOGO' => '/upload/panel/home.svg',
            'NAME' => 'Главная',
            'CODE' => 'content',
            'PATH' => '/admin/',
        ],
        [
            'LOGO' => '/upload/panel/content.png',
            'NAME' => 'Контент',
            'CODE' => 'content',
            'PATH' => '/admin/content/',
        ],
        [
            'LOGO' => '/upload/panel/main-menu.svg',
            'NAME' => 'Статистика',
            'CODE' => 'statistics',
            'PATH' => '/admin/statistics/',
        ],
        [
            'LOGO' => '/upload/panel/table.svg',
            'NAME' => 'Таблицы',
            'CODE' => 'models',
            'PATH' => '/admin/tables/',
        ],
        [
            'LOGO' => '/upload/panel/module.svg',
            'NAME' => 'Модули',
            'CODE' => 'models',
            'PATH' => '/admin/modules/',
        ],
        [
            'LOGO' => '/upload/panel/settings.svg',
            'NAME' => 'Настройки',
            'CODE' => 'settings',
            'PATH' => '/admin/settings/',
        ],
        [
            'LOGO' => '/upload/panel/client.svg',
            'NAME' => 'Клиенты',
            'CODE' => 'clients',
            'PATH' => '/admin/clients/',
        ],
        
    ];
    $settings["MAIN_MENU"] = $menu;
    
}

echo json_encode($settings);