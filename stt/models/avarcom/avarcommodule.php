<?
class AvarcomModule extends Module{

    protected $moduleName = "avarcom";
    protected $moduleTitle = "Аварком";
    protected $dependency = [
        "core" => [
            1,
        ],
        "google" => [
            1,
        ],
        "telegram" => [
            1,
        ],

    ];
    protected $arFields = [
        "lib" => [
            "avarcomgoogle", 
            "avarcomtelegram", 
            "avarstatistics", 
            "avarcommanage", 
        ], 
    ];

    protected $controllersList = [
        "avarcom" => [
            "avarcom"
        ],
        "avarcom-manage" => [
            "manage"
        ],
        "avarcom-statistics" => [
            "statistics"
        ]
    ];

    public function executeModule(){
        
    } 
}
