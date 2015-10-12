<?php
require_once("definitions/definitions.php");
require_once(DIR_FUNCTIONS ."general_func.php");
require_once(DIR_CLASSES ."app_class.php");
require_once("sschk.php");
	
class top_class extends app_class{
	function sub_init(){
	}
	function sub_main(){
	}
	function sub_disp(){
		//パンくずリスト
		$breadcrumb = array(
        );
		$this->smarty_obj->assign("a_breadcrumb",$breadcrumb);

		$this->smarty_obj->assign("t_html_title",$this->get_env("page_name") ."｜メインメニュー");
		$this->smarty_obj->assign("page_title","メインメニュー");

		$this->smarty_obj->assign("in_user_af",$_SESSION["sesAdFlg"]);

		$this->smarty_obj->display("top.tpl");
	}
}
unset($_SESSION['srch']);
unset($_SESSION['csv']);
$init_obj = new top_class;
$init_obj->sub_init();
$init_obj->sub_main();
$init_obj->sub_disp();
?>
