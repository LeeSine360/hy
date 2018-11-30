<?php 
define('DBHOST', 'localhost');
define('DBNAME', 'demo');
define('DBUSER', 'root');
define('DBPWD', '');
define('DBPREFIX', 'hw_');
define('DBCHARSET', 'utf8');
define('CONN', '');
define('TIMEZONE', 'Asia/Shanghai');

try{
    $db = new PDO('mysql:host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPWD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->query('SET NAMES utf8;');
}catch(PDOException  $e ){
    echo '{"result":"failed", "msg":"连接数据库失败！"}';
    exit;
}