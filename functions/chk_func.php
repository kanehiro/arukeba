<?php
/*
	chk_func.php　入力エラーチェック処理を行う関数群
	for PHP5
	Create:2015/04/07
	Update:
*/

	// 必須チェック
	function indi_check($p_string,$p_name){
		if(strlen($p_string) == 0){
			$err_msg = "「" .$p_name."」は必ず入力してください。";
			return($err_msg);
		}
	}
	//　文字数の最大長のチェック　charやvarchar型の出力時には必須
	function max_length_check($p_string,$p_length,$p_name){
		if(strlen($p_string) > $p_length){
			$err_msg = "「" .$p_name."が長すぎます。(最大半角".$p_length."文字)";
			return($err_msg);
		}
	}
	//	日付の妥当性検査
	function dateTypeCheck($p_string,$p_name){
		if(is_null($p_string)===FALSE && trim($p_string)!=''){
			if(!ereg("^[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}$",$p_string)){
				$err_msg = "「" .$p_name."」は日付形式で入力してください。";
				return($err_msg);
			} else{
				$aryStr=split("/",$p_string);
				if($p_string!=
					date("Y/m/d",mktime(0,0,0,$aryStr[1],$aryStr[2],$aryStr[0]))){
					// mktime関数の引数は月，日，年
					$err_msg = "「" .$p_name."」は日付形式で入力してください。";
					return($err_msg);
				}
			}
		}
	}
	// 数字のチェック
	function number_check($p_string,$p_name){
		if(strlen($p_string) != 0 && !preg_match("/^[0-9]+$/",$p_string)){
			$err_msg = "「" .$p_name."」は半角数字で入力してください。";
			return($err_msg);
		}
	}
	//半角数字（マイナス記号,ハイフン有り）のチェック
	function number_m_check($p_string,$p_name){
		if(strlen($p_string) != 0 && !preg_match("/^[0-9-]+$/",$p_string)){
			$err_msg = "「" .$p_name."」は半角数字で入力してください。";
			return($err_msg);
		}
	}
	//半角英数のチェック
	function hannum_check($p_string,$p_name){
		if(strlen($p_string) != 0 && !preg_match("/^[a-zA-Z0-9]+$/",$p_string)){
			$err_msg = "「" .$p_name."」は半角英数で入力してください。";
			return($err_msg);
		}
	}
	//半角英数（マイナス記号,ハイフン有り）のチェック
	function hannum_m_check($p_string,$p_name){
		if(strlen($p_string) != 0 && !preg_match("/^[a-zA-Z0-9-]+$/",$p_string)){
			$err_msg = "「" .$p_name."」は半角英数で入力してください。";
			return($err_msg);
		}
	}

	//半角英数ｶﾀｶﾅのチェック
	function hannumkana_check($p_string,$p_name){
		if(strlen($p_string) != 0 && !preg_match("/^(?:\xEF\xBD[\xA1-\xBF]|\xEF\xBE[\x80-\x9F]|[0-9A-Za-z])+$/",$p_string)){
			$err_msg = "「" .$p_name."」は半角英数ｶﾀｶﾅで入力してください。";
			return($err_msg);
		}
	}

	// ゼロチェック
	function zero_check($p_string,$p_name){
		if($p_string == 0){
			$err_msg = "「" .$p_name."」は0以上を入力してください。";
			return($err_msg);
		}
	}
	//空白チェック
	function blank_check($p_string,$p_name){
		if(strlen($p_string) != 0 && preg_match("/[^\s　]/",$p_string)){
			$err_msg = "「" .$p_name."」に空白が入っています。";
			return($err_msg);
		}
	}
	//	メールアドレスのチェック
	function mail_check($p_string){
		if(strlen($p_string) != 0 && !preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$p_string)){
			$err_msg = "メールアドレスを正しく入力してください。";
			return($err_msg);
		}
	}
	//	URLのチェック
	function url_check($p_string){
		if(strlen($p_string) != 0 && !preg_match('/^(https?|ftp):\/\/[-_\.!~*\'()a-z0-9;\/?:\@&=+\$,%#]+$/i',$p_string)){
			$err_msg = "URLを正しく入力してください。";
			return($err_msg);
		}
	}
?>