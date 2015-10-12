<?php
require_once("definitions/definitions.php");	//各種定数定義
require_once(DIR_FUNCTIONS ."chk_func.php");
require_once(DIR_CLASSES ."app_class.php");

class Login_class extends app_class{
	private $account;
	private $passwd;
	private $err_msg;
	
	function __construct(){
		parent::__construct();
	}
	private function login_check(){
		//必須チェック
		$this->err_msg[] = indi_check($this->account,"ユーザーID");
		$this->err_msg[] = indi_check($this->passwd,"パスワード");

		if(!array_filter($this->err_msg)){
			$this->sql = "SELECT * FROM " .TABLE_ACCNT
							." WHERE account = ?"
							." AND passwd = ?";
			$this->prepare();
			$this->data_array=array($this->account,$this->passwd);
			$this->execute();
			$row = $this->stmt->fetch(PDO::FETCH_ASSOC);
			if($row["account"] == $this->account){
				session_destroy();
				session_start();
				$_SESSION["sesUserID"] = $row["account"];
				$_SESSION["sesUserNM"] = $row["user_name"];
				$_SESSION["sesAdFlg"] = $row["admin_flg"];
				header("Location: top.php");
			}else{
				$this->err_msg[]="ユーザーIDまたはパスワードが間違っています。";
			}
		}
	}

	function sub_init(){
		$this->err_msg = array();
		if(isset($_POST["s_login"])){					//s_loginはsubmitボタン押下
			$this->account = $_POST["account"];
			$this->passwd = $_POST["passwd"];
			$this->login_check();
		}
	}
	function sub_main(){
		
	}
	function sub_disp(){
		$this->smarty_obj->assign("t_html_title",$this->get_env("page_name") ."｜ログイン");
		$this->smarty_obj->assign("page_title","ログイン");

		$this->smarty_obj->assign("err_msg",$this->err_msg);

		$this->smarty_obj->display("login.tpl");
	}
	function __destruct(){
		parent::__destruct();
	}
}
session_start();
//session_unset();
//session_destroy();
$init_obj = new Login_class;
$init_obj->sub_init();
$init_obj->sub_main();
$init_obj->sub_disp();
?>