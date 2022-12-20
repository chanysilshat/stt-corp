<?
    class STT
    {

        public $core;
        private $loadedObject;
        
        public function __construct(){
            $this->core = new Core();
        }   

        public function startProject(){
            global $PROJECT;
            
            $CoreModule = new CoreModule();
            
            ob_start();
            $this->core->openPage($_SERVER["REQUEST_URI"]);
        
            $page = ob_get_contents();

            ob_end_clean();
            if ($this->core->header){
                $page = Page::correctPage($page);
            } else {
                if ($this->core->load_script){
                    $script = "";
                    foreach ($PROJECT->projectJsScripts as $scripts){
                        $script .= '<script type="text/javascript" src="' . $scripts . '"></script>';
                    }
                }
                if ($this->core->load_css){
                    $css = "";
                    foreach ($PROJECT->projectStyles as $styles){
                        $css .= '<link href="' . $styles . '" rel="stylesheet">';
                    }
                }
            }
            //file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/page.txt", print_r($page, true));
            if ($this->core->load_script){
                $script = "";
                foreach ($PROJECT->projectJsScripts as $scripts){
                    $script .= '<script type="text/javascript" src="' . $scripts . '"></script>';
                }
                echo $script;

            }
            if ($this->core->load_css){
                $css = "";
                foreach ($PROJECT->projectStyles as $styles){
                    $css .= '<link href="' . $styles . '" rel="stylesheet">';
                }
                echo $css;
            }
            
            echo $page;
        }

        //Подключает файлы автозагрузки 
        public function setAutoLoadedObject($loaded){
            $this->core->$loadedObject = $loaded;
        }
    }
