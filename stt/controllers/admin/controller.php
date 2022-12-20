<?
class AdminController extends Controller
{
    public $params = [];

    public function executeController(){
        global $PROJECT;
        $PROJECT->title = "admin";
        $tables = $PROJECT->objects["TABLES"]->getTables();

    }
}