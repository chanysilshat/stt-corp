<?
class Page{

    public static function correctPage($buffer){
        global $PROJECT;
        //echo "<pre>"; print_r($PROJECT->projectStyles); echo "</pre>";
        //echo "<pre>"; print_r($PROJECT->projectJsScripts); echo "</pre>";
        //<link href="/media/examples/link-element-example.css" rel="stylesheet">

        //$title = "Тестовый тайтл";
        file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/page.txt", print_r($buffer, true));
        
        $title = $PROJECT->title;
        $keywords = $PROJECT->keywords;
        $description = $PROJECT->description;
        $css = '';
        foreach ($PROJECT->projectStyles as $styles){
            $css .= '<link href="' . $styles . '" rel="stylesheet">';
        }

        foreach ($PROJECT->projectJsScripts as $scripts){
            $script .= '<script type="text/javascript" src="' . $scripts . '"></script>';
        }

        $meta = '<meta name="viewport" content="width=device-width, initial-scale=1" />';
        $meta .= '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
        $meta .= '<meta charset="UTF-8">';

        $meta .= '<meta name="keywords" content="' . $keywords . '">';
        $meta .= '<meta name="description" content="' . $description . '">';

        if (strpos($buffer, "<head></head>") !== false){
            $buffer = preg_replace('|(<head>)(</head>)|isU', "$1" . $meta . $css . $script . "$2", $buffer);  
        } else {
            $buffer = preg_replace('|(<head>)(.+?)(</head>)|isU', "$1 $2 " . $meta . $css . $script . "$3", $buffer);    
        }

        if (strpos($buffer, "<title></title>") !== false){
            $buffer = preg_replace('|(<title>)(</title>)|isU', "$1 " . $title . " $2", $buffer);    
        } else{
            if (preg_match('|(<title>)(.+?)(</title>)|isU', $buffer)){
                $buffer = preg_replace('|(<title>)(.+?)(</title>)|isU', "$1 " . $title . " $3", $buffer);    
            } else {
                $buffer = preg_replace('|(<head>)(.+?)(</head>)|isU', "$1 $2 <title>" . $title . "</title>$3", $buffer);    
            }
        }
    
        return $buffer;
    } 
}