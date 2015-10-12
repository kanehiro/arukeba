<?php
require_once("definitions/definitions.php");            //各種定数定義
require_once(DIR_DEFINITIONS ."defdbmysql.php");	//MySQLDB定義

//ファイル作成
$json_out_string = file_get_contents('php://input'); 
file_put_contents('tmp/recieved_json.txt', $json_out_string);

//ファイル取得 
$json_string = file_get_contents('tmp/recieved_json.txt'); 
$array = json_decode($json_string,true);
$array0 = $array["ROUTE"][0]["ACCOUNT"][0];
$connect_user = $array0["Account"];         // アカウント
$connect_password = $array0["Password"];    // パスワード
//DB接続文字列
  
$dsn = DB_TYPE.":dbname=".DB_DATABASE.";"."host=".DB_SERVER;
$db_user = DB_SERVER_USERNAME;        
$db_password = DB_SERVER_PASSWORD;
try {
    // MySQL 接続
    $dbh = new PDO($dsn, $db_user, $db_password);
    if ($dbh == null){
        //print('接続に失敗しました。<br>');
    }else{
        //print('接続に成功しました。<br>');
    }
    $dbh->query('SET NAMES utf8');
    // TODO : ここにaccounttbに存在するかチェックを入れる
    // 有効なアカウントとパスワードか
    $confirm_sql= "SELECT account FROM accounttb"
                                ." where account = ? and passwd = ?";
    $confirm_stmt=$dbh->prepare($confirm_sql);
    $confirm_stmt->execute(array($connect_user,$connect_password));
    $count=$confirm_stmt->rowCount();
    if ($count> 0 ){
        // 有効なアカウントとパスワード
    } else {
        // 無効なアカウントとパスワード
        exit("Unkown User");
    }

    $delsql1 = "DELETE FROM routetb where routerec_id = ? and account = ?";
    $delstmt1 = $dbh->prepare($delsql1);

    $delsql2 = "DELETE FROM latlontb where routerec_id = ? and account = ?";
    $delstmt2 = $dbh->prepare($delsql2);

    $sql1 = "INSERT INTO routetb (route_name,startdatetime,routerec_id,account) VALUES (?, ?, ?, ?)";
    $stmt1 = $dbh->prepare($sql1);

    $array1= $array["ROUTE"][1]["ROUTEREC"][0];
    if (!empty($array1)) {
        $delstmt1->execute(array($array1["RouteId"],$connect_user));
        $delstmt2->execute(array($array1["RouteId"],$connect_user));
        
        $date_str=date(("Y-m-d H:i:s"),$array1["StartDateTimeMillis"]/1000); 
        $stmt1->execute(array($array1["RouteName"],$date_str,$array1["RouteId"],$connect_user));
        $last_id = $dbh->lastInsertId('id');  
    }
    $sql2 = "INSERT INTO latlontb (latitude,longitude,point_name,datetime,routerec_id,account,route_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt2 = $dbh->prepare($sql2);
    $array2= $array["ROUTE"][2]["LATLONREC"];
    //print_r($array2);
    if (!empty($array2)) {
        foreach ($array2 as $key => $val1) {
                //print_r($val1);	
                $pname="";
                if (array_key_exists("PointName",$val1)) {
                    $pname=$val1["PointName"]; 
                }
                $date_str=date(("Y-m-d H:i:s"), $val1["DatetimeMillis"] / 1000);
                //print($date_str." ");
                $stmt2->execute(array($val1["Latitude"],$val1["Longitude"],$pname,$date_str,$val1["RouteId"],$connect_user,$last_id));
        }
    }
    
    //$arr = array('result' => 'OK');
    $arr = array('result' => 0);

    echo json_encode($arr);
} catch (Exception $ex) {
    print('Error:'.$ex->getMessage());
    $arr = array('result' => 1);
    die();
}
$dbh=null;
