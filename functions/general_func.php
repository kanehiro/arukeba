<?php
/*
	general_func.php　汎用的な関数群
	for PHP5
	Create:2004/12/21
	Update:
*/


/*
	小数点第３位を四捨五入して、小数点２位までを返す
*/
    function rnd2($num){
        $num = $num * 100;
        $num = round($num);
        $num = $num / 100;
        return $num;
    }
/*
	NULLだったらスペースを1つ返す関数
*/
    function n2sp($TestVar)	{
        if (is_null($TestVar)) {
            return "&nbsp;";
        } else {
            return $TestVar;
        }
    }

/*
	NULLだったら0を1つ返す関数
*/
    function n2zero($TestVar) {
        if (is_null($TestVar)) {
            return 0;
        } else {
            return $TestVar;
        }
    }
/*
	NULLだったら0を1つ返す関数
*/
    function no2zero($TestVar) {
        if ($TestVar == "") {
            return 0;
        } else {
            return $TestVar;
        }
    }

/*
	0だったらNULLを返す関数
*/
    function zero2n($TestVar) {
        if ($TestVar == 0) {
            return NULL;
        } else {
            return $TestVar;
        }
    }
/*
	0だったらスペースを1つ返す関数
*/
    function zero2sp($TestVar) {

        if ($TestVar == 0) {
            return "&nbsp;";
        } else {
            return $TestVar;
        }
    }

/*
	スペースを取り除く関数
*/
    function sp2n($string){
        $string = str_replace ("&nbsp;", "", $string);
        return $string;
    }

/*
    NULLでないかを判定する関数
    配列にも対応
*/
    function ez_not_null($value) {
        if (is_array($value)) {
          if (sizeof($value) > 0) {
            return true;
          } else {
            return false;
          }
        } else {
          if (($value != '') && ($value != 'NULL') && (strlen(trim($value)) > 0)) {
            return true;
          } else {
            return false;
          }
        }
    }

/*
	サニタイジング処理
*/
function ez_sanitize_string($string) {
    $string = str_replace ("&", "_", $string);
    $string = str_replace ("'", "_", $string);
    $string = str_replace ("\"", "_", $string);
    $string = str_replace ("<", "_", $string);
    $string = str_replace (">", "_", $string);
    $string = str_replace ("+", "_", $string);
    $string = str_replace (" ", "　", $string);
    //$string = str_replace (" ", "_", $string);
    //$string = str_replace (" ", "&nbsp;", $string);
    return $string;
}

    function ez_htmlspecialchars($string) {
/*
    ENT_QUOTESなどの設定に左右される
    $string=htmlspecialchars($string);
*/
        $string = str_replace("&", "&amp;", $string);
        $string = str_replace("<", "&lt;", $string);
        $string = str_replace(">", "&gt;", $string);
        $string = str_replace("\"", "&#39;", $string);
        $string = str_replace("'", "&quot;", $string);
        return $string;
    }
    function unhtmlspecialchars( $string )	{
        $string = str_replace ( '&amp;', '&', $string );
        $string = str_replace ( '&#039;', '\'', $string );
        $string = str_replace ( '&quot;', '"', $string );
        $string = str_replace ( '&lt;', '<', $string );
        $string = str_replace ( '&gt;', '>', $string );
        return $string;
    }
   
    // The HTML href link wrapper function
    function ez_href_link($page = '', $parameters = '', $connection = 'NONSSL', $add_session_id = true, $search_engine_safe = true) {
        if (!ez_not_null($page)) {
          die('</td></tr></table></td></tr></table><br><br><font color="#ff0000"><b>Error!</b></font><br><br><b>Unable to determine the page link!<br><br>');
        }

        if ($connection == 'NONSSL') {
          $link = HTTP_SERVER . DIR_WS_CATALOG;
        } elseif ($connection == 'SSL') {
          if (ENABLE_SSL == true) {
            $link = HTTPS_SERVER . DIR_WS_CATALOG;
          } else {
            $link = HTTP_SERVER . DIR_WS_CATALOG;
          }
        } else {
          die('</td></tr></table></td></tr></table><br><br><font color="#ff0000"><b>Error!</b></font><br><br><b>Unable to determine connection method on a link!<br><br>Known methods: NONSSL SSL</b><br><br>');
        }

        if (ez_not_null($parameters)) {
          $link .= $page . '?' . ez_output_string($parameters);
          $separator = '&';
        } else {
          $link .= $page;
          $separator = '?';
        }

        while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);

        if ( (SEARCH_ENGINE_FRIENDLY_URLS == 'true') && ($search_engine_safe == true) ) {
          while (strstr($link, '&&')) $link = str_replace('&&', '&', $link);

          $link = str_replace('?', '/', $link);
          $link = str_replace('&', '/', $link);
          $link = str_replace('=', '/', $link);

          $separator = '?';
        }

        if (isset($sid)) {
          $link .= $separator . ez_output_string($sid);
        }

        return $link;
    }
  // Parse the data used in the html tags to ensure the tags will not break
  function ez_parse_input_field_data($data, $parse) {
    return strtr(trim($data), $parse);
  }

  function ez_output_string($string, $translate = false, $protected = false) {
    if ($protected == true) {
      return htmlspecialchars($string);
    } else {
      if ($translate == false) {
        return ez_parse_input_field_data($string, array('"' => '&quot;'));
      } else {
        return ez_parse_input_field_data($string, $translate);
      }
    }
  }
// The HTML image wrapper function
  function ez_image($src, $alt = '', $width = '', $height = '', $parameters = '') {
    if ( (empty($src) || ($src == DIR_WS_IMAGES)) && (IMAGE_REQUIRED == 'false') ) {
      return false;
    }

// alt is added to the img tag even if it is null to prevent browsers from outputting
// the image filename as default
    $image = '<img src="' . ez_output_string($src) . '" border="0" alt="' . ez_output_string($alt) . '"';

    if (ez_not_null($alt)) {
      $image .= ' title=" ' . ez_output_string($alt) . ' "';
    }

    if ( (CONFIG_CALCULATE_IMAGE_SIZE == 'true') && (empty($width) || empty($height)) ) {
      if ($image_size = @getimagesize($src)) {
        if (empty($width) && ez_not_null($height)) {
          $ratio = $height / $image_size[1];
          $width = (int)$image_size[0] * $ratio;
        } elseif (ez_not_null($width) && empty($height)) {
          $ratio = $width / $image_size[0];
          $height = (int)$image_size[1] * $ratio;
        } elseif (empty($width) && empty($height)) {
          $width = (int)$image_size[0];
          $height = (int)$image_size[1];
        }
      } elseif (IMAGE_REQUIRED == 'false') {
        return false;
      }
    }

    if (ez_not_null($width) && ez_not_null($height)) {
      $image .= ' width="' . ez_output_string($width) . '" height="' . ez_output_string($height) . '"';
    }

    if (ez_not_null($parameters)) $image .= ' ' . $parameters;

    $image .= '>';

    return $image;
  }
?>