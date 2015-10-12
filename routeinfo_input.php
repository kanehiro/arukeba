<?php
require_once("definitions/definitions.php");
require_once(DIR_FUNCTIONS ."general_func.php");
require_once(DIR_FUNCTIONS ."chk_func.php");
require_once(DIR_CLASSES ."app_class.php");
require_once("sschk.php");

class routeinfo_input_class extends app_class{
    private $id;
    private $route_name;
    private $remarks;
    private $startdatetime;
    private $account;
    private $mode;
    private $err_msg;

    function __construct(){
        parent::__construct();
    }

    private function set_data(){
        $this->id = $_SESSION['route']['id'];
        $this->route_name = $_SESSION['route']['route_name'];
        $this->remarks = $_SESSION['route']['remarks'];
        $this->startdatetime = $_SESSION['route']['startdatetime'];
        $this->account = $_SESSION['route']['account'];
        $this->mode = $_SESSION['route']['mode'];
    }

    private function get_data(){
        $row = $this->stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['route']['id'] = $row['id'];
        $_SESSION['route']['route_name'] = $row['route_name'];
        $_SESSION['route']['remarks'] = $row['remarks'];
        $_SESSION['route']['startdatetime'] = $row['startdatetime'];
        $_SESSION['route']['account'] = $row['account'];
    }

    function sub_init(){
            $this->err_msg = array();
    }
    function sub_main(){
        if(!isset($_SESSION['route'])){
                if(isset($_GET["m_id"])){
                        $_SESSION['route']['mode'] = 2;				//更新
                        $this->sql= "SELECT * FROM " .TABLE_ROUTE
                                                ." where id = ?";
                        $this->prepare();
                        $this->data_array=array($_GET["m_id"]);
                        $this->execute();
                        $this->get_data();
                        $this->set_data();
                }else{
                        $_SESSION['route']['mode'] = 1;				//新規登録
                        $this->mode = $_SESSION['route']['mode'];
                }
        } else {
                //新規入力でブラウザの更新ボタンが押されたとき用の対策
                if($_SESSION['route']['mode'] == 1 && !isset($_SESSION['route']['upd_flg'])){
                } else {
                    //確認ページから戻ってきたとき
                    $this->set_data();
                }
        }
    }
    function sub_disp(){
        //パンくずリスト
        $breadcrumb = array(
                array('p_name' => 'メインメニュー', 'p_url' => 'top.php'),
                array('p_name' => 'ルート情報保守', 'p_url' => 'routeinfo_list.php'),
        );
        $this->smarty_obj->assign("a_breadcrumb",$breadcrumb);
        $this->smarty_obj->assign("t_html_title",$this->get_env("page_name") ."｜ルート情報登録）");
        $this->smarty_obj->assign("page_title","ルート情報");

        $this->smarty_obj->assign("id",$this->id);
        $this->smarty_obj->assign("route_name",$this->route_name);
        $this->smarty_obj->assign("remarks",$this->remarks);
        $this->smarty_obj->assign("startdatetime",$this->startdatetime);
        $this->smarty_obj->assign("account",$this->account);
        $this->smarty_obj->assign("mode",$this->mode);
        $this->smarty_obj->assign("err_msg",$this->err_msg);

        $this->smarty_obj->display("routeinfo_input.tpl");
    }
}
$init_obj = new routeinfo_input_class;
$init_obj->sub_init();
$init_obj->sub_main();
$init_obj->sub_disp();
?>