<?php
require_once("definitions/definitions.php");
require_once(DIR_FUNCTIONS ."general_func.php");
require_once(DIR_FUNCTIONS ."chk_func.php");
require_once(DIR_CLASSES ."app_class.php");
require_once("sschk.php");

class account_input_class extends app_class{
    private $account;
    private $passwd;
    private $user_name;
    private $mail_address;
    private $admin_flg;
    private $mode;
    private $err_msg;

    function __construct(){
        parent::__construct();
    }

    private function set_data(){
        $this->account = $_SESSION['acct']['account'];
        //$this->passwd = $_SESSION['acct']['passwd'];
        $this->user_name = $_SESSION['acct']['user_name'];
        $this->mail_address = $_SESSION['acct']['mail_address'];
        $this->admin_flg = $_SESSION['acct']['admin_flg'];
        $this->mode = $_SESSION['acct']['mode'];
    }

    private function get_data(){
        $row = $this->stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['acct']['account'] = $row['account'];
        $_SESSION['acct']['passwd'] = $row['passwd'];
        $_SESSION['acct']['user_name'] = $row['user_name'];
        $_SESSION['acct']['mail_address'] = $row['mail_address'];
	$_SESSION['acct']['admin_flg'] = $row['admin_flg'];
    }

    function sub_init(){
            $this->err_msg = array();
    }
    function sub_main(){
        if(!isset($_SESSION['acct'])){
                if(isset($_GET["m_id"])){
                        $_SESSION['acct']['mode'] = 2;				//更新
                        $this->sql= "SELECT * FROM " .TABLE_ACCNT
                                                ." where account = ?";
                        $this->prepare();
                        $this->data_array=array($_GET["m_id"]);
                        $this->execute();
                        $this->get_data();
                        $this->set_data();
                }else{
                        $_SESSION['acct']['mode'] = 1;				//新規登録
                        $this->mode = $_SESSION['acct']['mode'];
                }
        } else {
                //新規入力でブラウザの更新ボタンが押されたとき用の対策
                if($_SESSION['acct']['mode'] == 1 && !isset($_SESSION['acct']['upd_flg'])){
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
                array('p_name' => 'アカウント保守', 'p_url' => 'account_list.php'),
        );
        $this->smarty_obj->assign("a_breadcrumb",$breadcrumb);
        $this->smarty_obj->assign("t_html_title",$this->get_env("page_name") ."｜アカウント登録）");
        $this->smarty_obj->assign("page_title","アカウント登録");

        $this->smarty_obj->assign("account",$this->account);
        //$this->smarty_obj->assign("passwd",$this->passwd);
        $this->smarty_obj->assign("user_name",$this->user_name);
        $this->smarty_obj->assign("mail_address",$this->mail_address);
        $this->smarty_obj->assign("admin_flg",$this->admin_flg);
        $this->smarty_obj->assign("mode",$this->mode);
        $this->smarty_obj->assign("err_msg",$this->err_msg);

        $this->smarty_obj->display("account_input.tpl");
    }
}
$init_obj = new account_input_class;
$init_obj->sub_init();
$init_obj->sub_main();
$init_obj->sub_disp();
?>