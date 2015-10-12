<?php
require_once("definitions/definitions.php");
require_once(DIR_FUNCTIONS ."general_func.php");
require_once(DIR_CLASSES ."app_class.php");
require_once("sschk.php");

class account_list_class extends app_class{
	private $count;
	private $all_count;
	private $offset;
	private	$reccnt;
	private $current_page;
	private $max_page;
	
	function __construct(){
            parent::__construct();
	}

	function sub_init(){
            $this->sql = "SELECT * FROM " .TABLE_ACCNT;
            $this->prepare();
            $this->data_array=array();
            $this->all_count=$this->exec_query();

            if($this->current_page == ""){
                    $this->current_page = 1;
                    $this->offset=0;
            }
            $this->reccnt=10;
            $this->max_page = ceil($this->all_count/$this->reccnt); //ceilは切り上げ（$max_pageは表示最大ページ数）

            if(isset($_GET["page"])){
                $this->current_page = $_GET["page"];    //現在のページ
                $this->offset = ($this->current_page-1)*$this->reccnt;  //表示スタート数（何個目から表示するか？）
            }		
	}
	function sub_main(){
            $this->sql = "SELECT *  FROM " .TABLE_ACCNT
                                            ." ORDER BY account"
                                            ." LIMIT $this->offset,$this->reccnt";
            $this->prepare();
            $this->data_array=array();
            $this->count=$this->exec_query();
	}
	function sub_disp(){
            //パンくずリスト
            $breadcrumb = array(
                array('p_name' => 'メインメニュー', 'p_url' => 'top.php'),
            );
            $this->smarty_obj->assign("a_breadcrumb",$breadcrumb);
            
            $this->smarty_obj->assign("t_html_title",$this->get_env("page_name") ."｜アカウント保守");
            $this->smarty_obj->assign("page_title","アカウント保守");

            if ($this->count>0) {
                while($row = $this->stmt->fetch(PDO::FETCH_ASSOC)){
                    $this->smarty_obj->append("account",$row['account']);
                    //$this->smarty_obj->append("passwd",$row['passwd']);
                    $this->smarty_obj->append("user_name",$row['user_name']);
                    $this->smarty_obj->append("mail_address",$row['mail_address']."");
                    $this->smarty_obj->append("admin_flg",$row['admin_flg']);
                }
            }
            $this->smarty_obj->assign("p_before",$this->current_page-1);
            $this->smarty_obj->assign("p_after",$this->current_page+1);
            $this->smarty_obj->assign("current_page",$this->current_page);
            $this->smarty_obj->assign("max_page",$this->max_page);

            $this->smarty_obj->display("account_list.tpl");
	}
	function __destruct(){
		parent::__destruct();
	}
}
unset($_SESSION['acct']);
$init_obj = new account_list_class;
$init_obj->sub_init();
$init_obj->sub_main();
$init_obj->sub_disp();
?>