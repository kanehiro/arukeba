<?php
require_once("definitions/definitions.php");
require_once(DIR_FUNCTIONS ."general_func.php");
require_once(DIR_FUNCTIONS ."chk_func.php");
require_once(DIR_CLASSES ."app_class.php");
require_once("sschk.php");

class account_inputsub_class extends app_class{
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
    private function ss_input($account,$user_name,$mail_address,$admin_flg){
        $_SESSION['acct']['account'] = $account;
        $_SESSION['acct']['user_name'] = $user_name;
        $_SESSION['acct']['mail_address'] = $mail_address;
        $_SESSION['acct']['admin_flg'] = $admin_flg;
        $_SESSION['acct']['upd_flg'] = 1;		//inputページでブラウザの更新ボタンが押されたとき用の対策
    }
    private function set_data(){
        $this->account = $_SESSION['acct']['account'];
        $this->user_name = $_SESSION['acct']['user_name'];
        $this->mail_address = $_SESSION['acct']['mail_address'];
        $this->admin_flg = $_SESSION['acct']['admin_flg'];
        $this->mode = $_SESSION['acct']['mode'];
    }
    private function check_input(){
        if ($this->mode == 1){
                if ($this->check_dupli() > 0) {
                        $this->err_msg[] = "同じアカウントが既に存在します。";
                }
        }

        $this->err_msg[] = indi_check($this->account,"アカウント");
        // hannum_check 半角英数
        // $this->err_msg[] = hannum_check($this->account,"アカウント");
        // 8文字制限
        $this->err_msg[] = max_length_check($this->account,8,"アカウント");
        $this->err_msg[] = indi_check($this->user_name,"名前");
        $this->err_msg[] = max_length_check($this->user_name,30,"名前");
        $this->err_msg[] = mail_check($this->mail_address,"E-mail");
        $this->err_msg[] = max_length_check($this->mail_address,50,"E-mail");
    }
    function check_dupli(){
        $this->sql= "SELECT * FROM " .TABLE_ACCNT
                                ." where account = ?";
        $this->prepare();
        $this->data_array=array($this->account);
        $count=$this->exec_query();
        return $count;
    }
    function random($length = 8) {
        return substr(base_convert(hash('sha256', uniqid()), 16, 36), 0, $length);
    }
    function send_mail() {
        //
        //言語設定
        mb_language("ja");
        mb_internal_encoding("UTF-8");
 
        //メール送信
        $to = $this->mail_address;
        $subject = "歩けばそれがルート図になるアプリからのお知らせ";
        $body = "あなたのアカウントは ".$this->account ." です"."\n";
        $body .= "パスワードは ".$this->passwd ." です"."\n";
        $body .= "urlには ".$this->get_server_url() ." を登録してください"."\n";
        $from = "code4takaoka@e-nat.org";
        if(mb_send_mail($to, $subject, $body, "From:".$from)){
            //echo 'メール送信に成功致しました。<br/>';
        }else{
            //echo 'メール送信に失敗致しました。<br/>';
        }

    }
    function sub_init(){
        $this->err_msg = array();
        //btn_check押下の場合
        if(isset($_POST['btn_check'])){	
                $this->ss_input($_POST['account'],$_POST['user_name'],$_POST['mail_address'],$_POST['admin_flg']);
        }
        $this->set_data();
        $this->check_input();
    }
    function sub_main(){
        if(isset($_POST['btn_check'])){	
            if ($this->mode == 1){
                // パスワード生成
                $this->passwd=$this->random(8);
                $_SESSION['acct']['passwd'] = $this->passwd;
            } else {
                // パスワード生成しない
                $this->passwd="********";
            }
        }
        
        if(isset($_POST['btn_input'])){		//btn_input押下の場合
            $up_date = date("Y-m-d H:i:s");
            $this->passwd = $_SESSION['acct']['passwd'];
            if ($this->mode == 1){
                    $this->sql = "INSERT INTO " .TABLE_ACCNT;
                    $this->sql .= "(account,passwd,user_name,mail_address,admin_flg,up_date)";
                    $this->sql .= " values(?,?,?,?,?,?)";
                    print($this->sql);
                    $this->prepare();
                    $this->data_array=array($this->account,$this->passwd,$this->user_name,
                                                                    $this->mail_address,$this->admin_flg,$up_date);
                    $this->execute();
            } else {
                    $this->sql = "UPDATE " .TABLE_ACCNT ." SET ";
                    $this->sql .= "user_name=?,mail_address=?,admin_flg=?,up_date=?";
                    $this->sql .= " WHERE account = ?";
                    $this->prepare();
                    $this->data_array=array($this->user_name,$this->mail_address,
                                                                    $this->admin_flg,$up_date,$this->account);
                    $this->execute();
            }
            // メール送信
            if ($this->mode == 1){
                if (strlen($this->mail_address) != 0) {
                   $this->send_mail();
                }
            }
            header("Location: account_list.php");
        }
    }
    function sub_disp(){
            //print("passwd:". $this->passwd);
            //パンくずリスト
            $breadcrumb = array(
                    array('p_name' => 'メインメニュー', 'p_url' => 'top.php'),
                    array('p_name' => 'アカウント保守', 'p_url' => 'account_list.php'),
            );
            $this->smarty_obj->assign("a_breadcrumb",$breadcrumb);
            $this->smarty_obj->assign("account",$this->account);
            $this->smarty_obj->assign("passwd",$this->passwd);
            $this->smarty_obj->assign("user_name",$this->user_name);
            $this->smarty_obj->assign("mail_address",$this->mail_address);
            $this->smarty_obj->assign("admin_flg",$this->admin_flg);
            $this->smarty_obj->assign("mode",$this->mode);
            $this->smarty_obj->assign("err_msg",$this->err_msg);
            if(isset($_POST['btn_syusei'])){					//btn_syusei押下の場合
                    $this->smarty_obj->assign("t_html_title",$this->get_env("page_name") ."｜アカウント登録");
                    $this->smarty_obj->assign("page_title","アカウント登録");
                    header("Location: account_input.php");
            }
            if(isset($_POST['btn_check'])){					//btn_check押下の場合
                    $this->smarty_obj->assign("t_html_title",$this->get_env("page_name") ."｜アカウント登録（確認）");
                    $this->smarty_obj->assign("page_title","アカウント登録（確認）");
                    if(array_filter($this->err_msg)){
                            $this->smarty_obj->display("account_input.tpl");
                    } else {
                            $this->smarty_obj->display("account_check.tpl");
                    }
            }
    }
    function __destruct(){
            parent::__destruct();
    }
}
$init_obj = new account_inputsub_class;
$init_obj->sub_init();
$init_obj->sub_main();
$init_obj->sub_disp();
?>