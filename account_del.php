<?php
require_once("definitions/definitions.php");
require_once(DIR_FUNCTIONS ."general_func.php");
require_once(DIR_CLASSES ."app_class.php");
require_once("sschk.php");

class account_del_class extends app_class{
	private $account;   // 入れただけ
	private $user_name;

	function __construct(){
            parent::__construct();
	}

	private function get_data(){
            $row = $this->stmt->fetch(PDO::FETCH_ASSOC);
            $this->account = $row['account'];
            $this->user_name = $row['user_name'];
	}
	function sub_init(){
		if(isset($_GET["m_id"])){
			$_SESSION['acct']['account'] = $_GET["m_id"];
		}
	}
	function sub_main(){
		
		$this->sql= "SELECT * FROM " .TABLE_ACCNT
					." where account = ?";
		$this->prepare();
		$this->data_array=array($_SESSION['acct']['account']);
		$this->execute();
		$this->get_data();

		if(isset($_POST['btn_del'])){		//btn_del押下の場合
			$this->sql = "DELETE FROM " .TABLE_ACCNT;
			$this->sql .= " WHERE account  = ?";
			$this->prepare();
			$this->data_array=array($_SESSION['acct']['account']);
			$this->execute();
			header("Location: account_list.php");
		}
	}
	function sub_disp(){
            //パンくずリスト
            $breadcrumb = array(
                    array('p_name' => 'メインメニュー', 'p_url' => 'top.php'),
                    array('p_name' => 'アカウント保守', 'p_url' => 'account_list.php'),
            );
            $this->smarty_obj->assign("a_breadcrumb",$breadcrumb);
            $this->smarty_obj->assign("t_html_title",$this->get_env("page_name") ."｜アカウント保守（削除）");
            $this->smarty_obj->assign("page_title","アカウント保守（削除）");

            $this->smarty_obj->assign("account",$this->account);
            $this->smarty_obj->assign("user_name",$this->user_name);
            $this->smarty_obj->display("account_del.tpl");
	}

	function __destruct(){
		parent::__destruct();
	}
}
$init_obj = new account_del_class;
$init_obj->sub_init();
$init_obj->sub_main();
$init_obj->sub_disp();
?>