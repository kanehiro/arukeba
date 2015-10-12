<?php
require_once("definitions/definitions.php");
require_once(DIR_FUNCTIONS ."general_func.php");
require_once(DIR_CLASSES ."app_class.php");
require_once("sschk.php");

class routeinfo_list_class extends app_class{
	private $s_routename;
        private $s_account;
	private $err_msg;
	private $count;
	private $all_count;
	private $offset;
	private	$reccnt;
	private $current_page;
	private $max_page;
	
	function __construct(){
            parent::__construct();
	}
	private function ss_input(){
            if (isset($_POST['s_routename'])) {
                $routename = $_POST['s_routename'];
            } else {
                $routename = "";
            }
            if (isset($_POST['s_account'])) {
                $account = $_POST['s_account'];
            } else {
                $account = "";
            }
            $_SESSION['srch']['s_routename'] = $routename;
            $_SESSION['srch']['s_account'] = $account;
	}
	private function set_data(){
            $this->s_routename = $_SESSION['srch']['s_routename'];
            $this->s_account = $_SESSION['srch']['s_account'];
	}
	private function check_input(){
            // do nothing
	}

	function sub_init(){
            $this->err_msg = array();

            //検索フォームからsubmitされたとき
            if($_SERVER["REQUEST_METHOD"] == "POST"){
		$this->ss_input();
            }
		
            if (isset($_SESSION['srch'])){
                $this->set_data();
            }
		
            $this->check_input();
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
            $where = "";
            $and = "";

            if ($this->s_routename != "") {
                if ($where == ""){
                        $and = "";
                }else{
                        $and = " AND ";
                }
                $where = $where .$and .TABLE_ROUTE .".route_name LIKE '%" .$this->s_routename ."%'";
            }
            if ($this->s_account != "") {
                if ($where == ""){
                        $and = "";
                }else{
                        $and = " AND ";
                }
                $where = $where .$and .TABLE_ROUTE .".account LIKE '%" .$this->s_account ."%'";
            }

            if ($where != ""){
                    $where = " WHERE " .$where;
            }

            $_SESSION['outfile']['where'] = $where;

            $this->sql = "SELECT *  FROM " .TABLE_ROUTE
					.$where
					." ORDER BY id DESC";
            //print $this->sql;
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
            $this->smarty_obj->assign("t_html_title",$this->get_env("page_name") ."|一覧");
            $this->smarty_obj->assign("page_title","ルート情報保守");

            $this->smarty_obj->assign("in_user_name","ユーザー名");

            if ($this->count>0) {
                while($row = $this->stmt->fetch(PDO::FETCH_ASSOC)){
                    $this->smarty_obj->append("id",$row['id']);
                    $this->smarty_obj->append("route_name",$row['route_name']);
                    $this->smarty_obj->append("remarks",$row['remarks']."");
                    $this->smarty_obj->append("startdatetime",$row['startdatetime']);
                    $this->smarty_obj->append("account",$row['account']);
                }
            }

            $this->smarty_obj->assign("s_routename",$this->s_routename);
            $this->smarty_obj->assign("s_account",$this->s_account);

            $this->smarty_obj->assign("err_msg",$this->err_msg);
            
            $this->smarty_obj->assign("p_before",$this->current_page-1);
            $this->smarty_obj->assign("p_after",$this->current_page+1);
            $this->smarty_obj->assign("current_page",$this->current_page);
            $this->smarty_obj->assign("max_page",$this->max_page);
            $this->smarty_obj->display("routeinfo_list.tpl");
	}
	function __destruct(){
		parent::__destruct();
	}
}
unset($_SESSION['route']);
$init_obj = new routeinfo_list_class;
$init_obj->sub_init();
$init_obj->sub_main();
$init_obj->sub_disp();
?>


