<?php
require_once("definitions/definitions.php");
require_once(DIR_FUNCTIONS ."general_func.php");
require_once(DIR_CLASSES ."app_class.php");

class route_map_class extends app_class{
    private $m_id=0;
    private $latlonAry= array();
    function __construct(){
        parent::__construct();
    }

    function sub_init(){

        //検索フォームからsubmitされたとき
         
        if($_SERVER["REQUEST_METHOD"] == "GET"){
            if (isset($_GET['m_id'])) {
                $this->m_id = $_GET['m_id'];
            }
        }
    }
    
    function sub_main(){

        $where = " WHERE route_id = " .$this->m_id;
        $this->sql = "SELECT *  FROM " .TABLE_LATLON
                                    .$where
                                    ." ORDER BY id ASC";
       //print $this->sql;
        $this->prepare();
        $this->data_array=array();
        $this->count=$this->exec_query();
    }
    function sub_disp(){

            $this->smarty_obj->assign("t_html_title",$this->get_env("page_name") ."｜図");

            if ($this->count>0) {
                while($row = $this->stmt->fetch(PDO::FETCH_ASSOC)){
                    $this->latlonAry[]=array(
                        'id'=>$row['id'],
                        'latitude'=>$row['latitude'],
                        'longitude'=>$row['longitude'],
                        'point_name'=>$row['point_name']
                    );
                }
            }
            //print json_encode($this->latlonAry);
            $this->smarty_obj->assign("latlonAry",  json_encode($this->latlonAry));
            $this->smarty_obj->assign("routename", $this->get_route_name($this->m_id));

            $this->smarty_obj->display("route_map.tpl");
    }
    function __destruct(){
            parent::__destruct();
    }
}
//unset($_SESSION['stock']);
//unset($_SESSION['priced']);
$init_obj = new route_map_class;
$init_obj->sub_init();
$init_obj->sub_main();
$init_obj->sub_disp();
?>