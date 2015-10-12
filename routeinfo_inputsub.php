<?php
require_once("definitions/definitions.php");
require_once(DIR_FUNCTIONS ."general_func.php");
require_once(DIR_FUNCTIONS ."chk_func.php");
require_once(DIR_CLASSES ."app_class.php");
require_once("sschk.php");

class routeinfo_inputsub_class extends app_class{
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
    private function ss_input($id,$route_name,$remarks,$startdatetime,$account){
        $_SESSION['route']['id'] = $id;
        $_SESSION['route']['route_name'] = $route_name;
        $_SESSION['route']['remarks'] = $remarks;
        $_SESSION['route']['$startdatetime'] = $startdatetime;
        $_SESSION['route']['account'] = $account;
        $_SESSION['route']['upd_flg'] = 1;		//inputページでブラウザの更新ボタンが押されたとき用の対策
    }
    private function set_data(){
        $this->id = $_SESSION['route']['id'];
        $this->route_name = $_SESSION['route']['route_name'];
        $this->remarks = $_SESSION['route']['remarks'];
        $this->startdatetime = $_SESSION['route']['startdatetime'];
        $this->account = $_SESSION['route']['account'];
        $this->mode = $_SESSION['route']['mode'];
    }
    private function check_input(){
        if ($this->mode == 1){
                if ($this->check_dupli() > 0) {
                        $this->err_msg[] = "同じルートIDが既に存在します。";
                }
        }

        $this->err_msg[] = indi_check($this->route_name,"ルート名");
        $this->err_msg[] = max_length_check($this->route_name,50,"名前");
        $this->err_msg[] = max_length_check($this->remarks,100,"備考");
    }
    function check_dupli(){
        $this->sql= "SELECT * FROM " .TABLE_ROUTE
                                ." where id = ?";
        $this->prepare();
        $this->data_array=array($this->id);
        $count=$this->exec_query();
        return $count;
    }
    function sub_init(){
        $this->err_msg = array();
        //btn_check押下の場合
        if(isset($_POST['btn_check'])){	
                $this->ss_input($_POST['id'],$_POST['route_name'],$_POST['remarks'],$_POST['startdatetime'],$_POST['account']);
        }
        $this->set_data();
        $this->check_input();
    }
    function sub_main(){
        
        if(isset($_POST['btn_input'])){		//btn_input押下の場合
            if ($this->mode == 1){
                    $this->sql = "INSERT INTO " .TABLE_ROUTE;
                    $this->sql .= "(id,route_name,startdatetime,routerec_id,account)";
                    $this->sql .= " values(?,?,?,?,?)";
                    print($this->sql);
                    $this->prepare();
                    $this->data_array=array($this->id,$this->route_name,$this->startdatetime,$this->routerec_id,$this->account);
                    $this->execute();
            } else {
                    $this->sql = "UPDATE " .TABLE_ROUTE ." SET ";
                    $this->sql .= "route_name=?,remarks=?";
                    $this->sql .= " WHERE id = ?";
                    $this->prepare();
                    $this->data_array=array($this->route_name,$this->remarks,$this->id);
                    $this->execute();
            }
            header("Location: routeinfo_list.php");
        }
    }
    function sub_disp(){
            //print("passwd:". $this->passwd);
            //パンくずリスト
            $breadcrumb = array(
                    array('p_name' => 'メインメニュー', 'p_url' => 'top.php'),
                    array('p_name' => 'ルート情報保守', 'p_url' => 'routeinfo_list.php'),
            );
            $this->smarty_obj->assign("a_breadcrumb",$breadcrumb);
            $this->smarty_obj->assign("id",$this->id);
            $this->smarty_obj->assign("route_name",$this->route_name);
            $this->smarty_obj->assign("remarks",$this->remarks);
            $this->smarty_obj->assign("startdatetime",$this->startdatetime);
            $this->smarty_obj->assign("account",$this->account);
            $this->smarty_obj->assign("mode",$this->mode);
            $this->smarty_obj->assign("err_msg",$this->err_msg);
            if(isset($_POST['btn_syusei'])){					//btn_syusei押下の場合
                    $this->smarty_obj->assign("t_html_title",$this->get_env("page_name") ."｜ルート情報登録");
                    $this->smarty_obj->assign("page_title","ルート情報登録");
                    header("Location: routeinfo_input.php");
            }
            if(isset($_POST['btn_check'])){					//btn_check押下の場合
                    $this->smarty_obj->assign("t_html_title",$this->get_env("page_name") ."｜ルート情報登録（確認）");
                    $this->smarty_obj->assign("page_title","ルート情報登録（確認）");
                    if(array_filter($this->err_msg)){
                            $this->smarty_obj->display("routeinfo_input.tpl");
                    } else {
                            $this->smarty_obj->display("routeinfo_check.tpl");
                    }
            }
    }
    function __destruct(){
            parent::__destruct();
    }
}
$init_obj = new routeinfo_inputsub_class;
$init_obj->sub_init();
$init_obj->sub_main();
$init_obj->sub_disp();
?>