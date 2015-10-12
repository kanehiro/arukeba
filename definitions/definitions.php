<?php
//  テーブル名の定義
    define('TABLE_ACCNT', 'accounttb');
    define('TABLE_ROUTE', 'routetb');
    define('TABLE_LATLON', 'latlontb');
    define('TABLE_SERVER', 'servertb');

    define('SC_CHAR', 'UTF8');


    //define('PATH_HOME','http://192.168.8.75/~kanehiro/arukeba/');	//テストサーバー
    //define('PATH_HOME','http://210.42.176.6/~kanehiro/arukeba/');	//本番サーバー
    define('PATH_HOME','/var/www/html/arukeba');

    //	ディレクトリ名の定義
    define('DIR_DEFAULT', '/arukeba/');
    define('DIR_DEFINITIONS', 'definitions/');
    define('DIR_FUNCTIONS', 'functions/');
    define('DIR_SMARTY', '');
    define('DIR_CLASSES', 'app_classes/');
    define('DIR_PHPEXCEL_CLASSES', 'Classes/');
    //define('DIR_DOWN',  PATH_HOME .'down_file/');

    //Excel出力ファイル名の定義
    // define('EXCEL_STOCK',  'zaiko');


    //	テンプレートディレクトリ
    define('TEMPLATE_DIR','templates');
    define('COMPILE_DIR','templates_c');
    define('CONFIG_DIR','config');

    //テストサーバー
    //define('HTTP_SERVER', '192.168.8.75');
    //define('HTTPS_SERVER', '192.168.8.75');

    //本番サーバー
    define('HTTP_SERVER', 'www.code4takaoka.org');
    define('HTTPS_SERVER', 'www.code4takaoka.org');	
?>