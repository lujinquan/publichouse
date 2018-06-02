<?php

set_time_limit(8000);

header('Content-Type:text/html; charset=utf-8'); //网页编码



//配置文件完成相关配置
define("HOST", "localhost");
define("USER", 'root');
define("PWD", 'ctnm');
define("DB", 'ph20180518');

//建立连接，生成mysqli实例对象。
$mysqli=new Mysqli(HOST,USER,PWD,DB);

if ($mysqli->connect_errno) {
    "Connect Error:".$mysqli->connect_error;
}
//设置默认的字符集
$mysqli->set_charset('utf8');







$results=$mysqli->query("select max(BanID) from ld_zanting where BanID !='' group by BanID");
$results = $results->fetch_all(MYSQLI_ASSOC);

// echo '<pre>';
// var_dump($results);

$re = $mysqli->query("delete from ld_zanting where id not in ".$results);
echo $re;
