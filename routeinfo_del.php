<?php
require_once("definitions/definitions.php");
require_once(DIR_FUNCTIONS ."general_func.php");
require_once(DIR_CLASSES ."app_class.php");
require_once("sschk.php");

class routeinfo_del_class extends app_class{
	private $id;
	private $route_name;
	private $account;

	function __construct(){
            parent::__construct();
	}

	private function get_data(){
            $row = $this->stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->route_name = $row['route_name'];
            $this->account = $row['account'];
	}
	function sub_init(){
		if(isset($_GET["m_id"])){
			$_SESSION['route']['id'] = $_GET["m_id"];
		}
	}
	function sub_main(){
		
		$this->sql= "SELECT * FROM " .TABLE_ROUTE
					." where id = ?";
		$this->prepare();
		$this->data_array=array($_SESSION['route']['id']);
		$this->execute();
		$this->get_data();

		if(isset($_POST['btn_del'])){		//btn_del押下の場合
			$this->sql = "DELETE FROM " .TABLE_ROUTE;
			$this->sql .= " WHERE id  = ?";
			$this->prepare();
			$this->data_array=array($_SESSION['route']['id']);
			$this->execute();
			header("Location: routeinfo_list.php");
		}
	}
	function sub_disp(){
            //パンくずリスト
            $breadcrumb = array(
                    array('p_name' => 'メインメニュー', 'p_url' => 'top.php'),
                    array('p_name' => 'ルート情報保守', 'p_url' => 'routeinfo_list.php'),
            );
            $this->smarty_obj->assign("a_breadcrumb",$breadcrumb);
            $this->smarty_obj->assign("t_html_title",$this->get_env("page_name") ."｜ルート情報保守（削除）");
            $this->smarty_obj->assign("page_title","ルート情報保守（削除）");

            $this->smarty_obj->assign("id",$this->id);
            $this->smarty_obj->assign("route_name",$this->route_name);
            $this->smarty_obj->assign("account",$this->account);
            $this->smarty_obj->display("routeinfo_del.tpl");
	}

	function __destruct(){
		parent::__destruct();
	}
}
$init_obj = new routeinfo_del_class;
$init_obj->sub_init();
$init_obj->sub_main();
$init_obj->sub_disp();
?>