<?
class Manage{

    public function __construct()
    {   
        
    }

    public static function getPanelModules()
    {
        
    }

    public static function getMainAdminMenu()
    {
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
            [
                'LOGO' => '/upload/panel/update.svg',
                'NAME' => 'Обновления',
                'CODE' => 'updates',
                'PATH' => '/admin/updates/',
            ],
            [
                'LOGO' => '/upload/panel/update.svg',
                'NAME' => 'Режим разработчика',
                'CODE' => 'updates',
                'PATH' => '/admin/updates/',
            ],
        ];

        return $menu;
    }
} 

?>