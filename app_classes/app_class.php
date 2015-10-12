
<?php
/*
	app_class.php
	database,smarty,マスタ関連クラス
	マスタarray
	Copyright (c) 2004 easier
  
	Released under the GNU General Public License
*/
require_once("definitions/definitions.php");            //各種定数定義
require_once(DIR_DEFINITIONS ."defdbmysql.php");	//MySQLDB定義
require_once(DIR_SMARTY ."Smarty.class.php");

//require_once (DBX_LIB);
//use \Dropbox as dbx;

// 抽象クラス　必ず継承して使わなくていけない（都合が悪いときがあれば直そう！）
abstract class app_class {
	public	$db_obj;
	public	$sql;
	public	$data_array;
	public	$res;
	private	$env_array;
	private	$dsn;
	
	public	$smarty_obj;

	function __construct(){
            $this->set_env();

            //dsn作成
            $this->dsn = $this->env_array["db_type"] .":host=" .$this->env_array["db_host"]
                                                    .";dbname=" .$this->env_array["db_name"]
                                                    .";charset=" .$this->env_array["db_charset"];
            $this->db_user = $this->env_array["db_user"];
            $this->db_pass = $this->env_array["db_pass"];

            //	接続
            $this->db_connect();

            //Smarty
            $this->smarty_obj = new Smarty();
            $this->smarty_obj->template_dir = $this->env_array["template_dir"];
            $this->smarty_obj->compile_dir = $this->env_array["compile_dir"];
            $this->smarty_obj->config_dir = $this->env_array["config_dir"];
	}
	private function set_env(){
            // definitions.phpの定数定義より編集
            $this->env_array["db_type"] = DB_TYPE;
            $this->env_array["db_host"] = DB_SERVER;
            $this->env_array["db_charset"] = DB_CHARSET;
            $this->env_array["db_name"] = DB_DATABASE;
            $this->env_array["db_user"] = DB_SERVER_USERNAME;
            $this->env_array["db_pass"] = DB_SERVER_PASSWORD;
            $this->env_array["template_dir"] = TEMPLATE_DIR;
            $this->env_array["compile_dir"] = COMPILE_DIR;
            $this->env_array["config_dir"] = CONFIG_DIR;
            $this->env_array["page_name"] ="歩けばそれがルート図になる";
	}
	private function db_connect() {
            try {
                // 接続
                $this->pdo = new PDO($this->dsn, $this->db_user, $this->db_pass);
                $this->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
            } catch(PDOException $e){
                var_dump($e->getMessage());
                die("Error Code=" .$e->getCode() .":" .$e->getMessage()); 
            }
	}
	
	// prepareメソッドを使うとSQLインジェクションの防止になる
	public function prepare() {
            try {
                $this->stmt = $this->pdo->prepare($this->sql); 
            } catch(PDOException $e){
                die("prepare() Error Code=" .$e->getCode() .":" .$e->getMessage()); 
            }
	}
	//実行
	public function execute() {
            try {
                $this->stmt->execute($this->data_array);
            } catch(PDOException $e){
                die("execute() Error Code=" .$e->getCode() .":" .$e->getMessage()); 
            }
	}
	//レコード数 取得
	public function exec_query() {
            try {
                $this->stmt->execute($this->data_array);
            } catch(PDOException $e){
                die("exec_query() Error Code=" .$e->getCode() .":" .$e->getMessage()); 
            }
            $count=$this->stmt->rowCount();
            return($count);
	}
	//最後に挿入された行の ID 取得
	public function exec_last_id() {
            try {
                $this->stmt->execute($this->data_array);
            } catch(PDOException $e){
                die("exec_last_id() Error Code=" .$e->getCode() .":" .$e->getMessage()); 
            }
            $last_id=$this->pdo->lastInsertId();
            return($last_id);
	}

	public function get_page_name(){
            return $this->get_env("page_name")."[".$_SESSION["sesUserID"]."]";
	}

	public function get_env($p_key)	{
            return $this->env_array[$p_key];
	}

	//utf8をShift_JISに変換する。
	public function sjis_conv($conv_str) {
		return (mb_convert_encoding($conv_str, "SJIS", SC_CHAR));
	}

	//utf8をEUC-JPに変換。
	public function euc_conv($conv_str) {
		return (mb_convert_encoding($conv_str, "EUC-JP", SC_CHAR));
	}

	public function get_yobi($w_date){
            $week_array = array('日', '月', '火', '水', '木', '金', '土');
            //日付を指定
            $w_year = substr($w_date, 0, 4);
            $w_month = substr($w_date, 5, 2);
            $w_day = substr($w_date, 8, 2);

            //タイムスタンプを取得
            $w_ts = mktime(0, 0, 0, $w_month, $w_day, $w_year);
            //曜日番号を取得
            $w_wno = date('w', $w_ts);
            //日本語の曜日を出力
            $w_week = $week_array[$w_wno];
            return $w_week;
	}
	
	//日付を2015-01-01から2015/01/01にフォーマット
	public function date_format_ymd($p_date) {
            if ($p_date == "0000-00-00") {
                $w_date = "";
            } else {
                $w_date = date('Y/m/d', strtotime($p_date));
            }
            return $w_date;
	}

	//日付を2015-01-01から2015/01にフォーマット
	public function date_format_ym($p_date) {
            if ($p_date == "0000-00-00") {
                $w_date = "";
            } else {
                $w_date = date('Y/m', strtotime($p_date));
            }
            return $w_date;
	}

        //元号array
	public function gengo_array(){
		$gengo_array = array();
		$gengo_array["id"][] = "";
		$gengo_array["name"][] = "元号";
		$gengo_array["id"][] = "H";
		$gengo_array["name"][] = "H";
		return $gengo_array;
	}

        //和暦年2桁array
	public function wyear_array(){
            $wyear_array = array();
            $wyear_array["id"][] = "";
            $wyear_array["name"][] = "和暦年";
            for($a = 1; $a <= 50; $a++) {
                $wyear_array["id"][] = sprintf("%02d",$a);
                $wyear_array["name"][] = sprintf("%02d",$a);
            }
            return $wyear_array;
	}

        //月2桁array
	public function month_array(){
            $month_array = array();
            $month_array["id"][] = "";
            $month_array["name"][] = "月";
            for($b = 1; $b <= 12; $b++) {
                $month_array["id"][] = sprintf("%02d",$b);
                $month_array["name"][] = sprintf("%02d",$b);
            }
            return $month_array;
	}
	       
	//価格帯別回転率用プライスarray
	public function price_array(){
            $this->price_arry = array();
            $this->price_arry["price_from"][] = "0";
            $this->price_arry["price_to"][] = "399000";
            $this->price_arry["price_from"][] = "400000";
            $this->price_arry["price_to"][] = "449000";
            $this->price_arry["price_from"][] = "450000";
            $this->price_arry["price_to"][] = "499000";
            $this->price_arry["price_from"][] = "500000";
            $this->price_arry["price_to"][] = "540000";
            $this->price_arry["price_from"][] = "540000";
            $this->price_arry["price_to"][] = "549000";
            $this->price_arry["price_from"][] = "550000";
            $this->price_arry["price_to"][] = "599000";
            $this->price_arry["price_from"][] = "600000";
            $this->price_arry["price_to"][] = "649000";
            $this->price_arry["price_from"][] = "650000";
            $this->price_arry["price_to"][] = "699000";
            $this->price_arry["price_from"][] = "700000";
            $this->price_arry["price_to"][] = "749000";
            $this->price_arry["price_from"][] = "750000";
            $this->price_arry["price_to"][] = "799000";
            $this->price_arry["price_from"][] = "800000";
            $this->price_arry["price_to"][] = "849000";
            $this->price_arry["price_from"][] = "850000";
            $this->price_arry["price_to"][] = "899000";
            $this->price_arry["price_from"][] = "900000";
            $this->price_arry["price_to"][] = "949000";
            $this->price_arry["price_from"][] = "950000";
            $this->price_arry["price_to"][] = "999000";
            $this->price_arry["price_from"][] = "1000000";
            $this->price_arry["price_to"][] = "1049000";
            $this->price_arry["price_from"][] = "1050000";
            $this->price_arry["price_to"][] = "1099000";
            $this->price_arry["price_from"][] = "1100000";
            $this->price_arry["price_to"][] = "1149000";
            $this->price_arry["price_from"][] = "1150000";
            $this->price_arry["price_to"][] = "1199000";
            $this->price_arry["price_from"][] = "1200000";
            $this->price_arry["price_to"][] = "1249000";
            $this->price_arry["price_from"][] = "1250000";
            $this->price_arry["price_to"][] = "1299000";
            $this->price_arry["price_from"][] = "1300000";
            $this->price_arry["price_to"][] = "1349000";
            $this->price_arry["price_from"][] = "1350000";
            $this->price_arry["price_to"][] = "1399000";
            $this->price_arry["price_from"][] = "1400000";
            $this->price_arry["price_to"][] = "1449000";
            $this->price_arry["price_from"][] = "1450000";
            $this->price_arry["price_to"][] = "1499000";
            return $this->price_arry;
	}

        //getマスタ
        // ルート名取得
	public function get_route_name($route_id){
            $this->sql= "SELECT route_name FROM " .TABLE_ROUTE
                                                ." where id = ?";
            $this->prepare();
            $this->data_array=array($route_id);
            $this->execute();
            $count=$this->exec_query();
            if ($count> 0 ){
                $row1 = $this->stmt->fetch(PDO::FETCH_ASSOC);
                $route_name = $row1['route_name'];
            } else {
                $route_name = "";
            }
            return $route_name;
	}
        // servertbからurlを取得
	public function get_server_url($server_id = 1){
            $this->sql= "SELECT url FROM " .TABLE_SERVER
                                                ." where id = ?";
            $this->prepare();
            $this->data_array=array($server_id);
            $this->execute();
            $count=$this->exec_query();
            if ($count> 0 ){
                $row1 = $this->stmt->fetch(PDO::FETCH_ASSOC);
                $url = $row1['url'];
            } else {
                $url = "";
            }
            return $url;
	}
        //Dropboxの共有フォルダ内のファイル操作
	//リンクを取得する
        /*
	function dbx_get_url($file_name){
		if ($file_name != ""){
			$accessToken = ACCESS_TOKEN;
			$clientIdentifier = CLIENT_IDENT;
			$dbxClient = new dbx\Client($accessToken, $clientIdentifier);
			$path = DIR_SHARE ."/" .$file_name;
			$download_url = $dbxClient->createShareableLink($path);
		} else {
			$download_url = "";
		}
		return $download_url;
	}
        */
	//ファイルを削除する
        /*
	function dbx_del_file($file_name){
		if ($file_name != ""){
			$accessToken = ACCESS_TOKEN;
			$clientIdentifier = CLIENT_IDENT;
			$dbxClient = new dbx\Client($accessToken, $clientIdentifier);
			$path = DIR_SHARE ."/" .$file_name;

			$dbxClient->delete($path, dbx\WriteMode::add());
		}
	}
        */
        
//-------------
  abstract protected function sub_init();
  abstract protected function sub_main();
  abstract protected function sub_disp();

  function __destruct() {
        $this->pdo = null;
  }
}