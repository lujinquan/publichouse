<?php

set_time_limit(8000);

header('Content-Type:text/html; charset=utf-8'); //网页编码



//配置文件完成相关配置
define("HOST", "sh-cdb-r8lcilx2.sql.tencentcdb.com:63889");
define("USER", 'root');
define("PWD", 'Wfw@ctnm0401');
define("DB", 'PH');

//建立连接，生成mysqli实例对象。
$mysqli=new Mysqli(HOST,USER,PWD,DB);

if ($mysqli->connect_errno) {
    "Connect Error:".$mysqli->connect_error;
}
//设置默认的字符集
$mysqli->set_charset('utf8');






$results=$mysqli->query("select HouseID,TenantName,HousePrerent,BanAddress from ph_house where InstitutionID = 14 and OwnerType = 2");
$results = $results->fetch_all(MYSQLI_ASSOC);

//halt($results);

// //给报表中的房屋信息加编号
// foreach($results as $res){
//  	$mysqli->query("update old_house_14qu set HouseID = '".$res['HouseID']."' where TenantName = '".$res['TenantName']."'");
// }exit;

//halt($results);

// while($row = mysqli_fetch_assoc($results)){

// 	$arr[$row['HouseID']] = $row;
// 	$resultss[] = $row;
// }


//获取报表中的所有匹配到房屋编号的数据
$result=$mysqli->query("select HouseID,TenantName,HousePrerent,BanAddress from old_house_14qu where HouseID != ''");
// $result = $result->fetch_all(MYSQLI_ASSOC);
// halt($result);

//获取报表中的所有未匹配到房屋编号的数据
$result2=$mysqli->query("select TenantName,HousePrerent,BanAddress from old_house_14qu where HouseID =''");
// $result2 = $result2->fetch_all(MYSQLI_ASSOC);

foreach($results as $vv){
	
	$arr[$vv['HouseID']] = $vv;
}

	$html = '';

	$html .= '  <h3 >紫阳11管段赵劲涛区属</h3>'."\n";
    $html .= '  <table border="1" cellspacing="0" cellpadding="0" width="100%">'."\n";
    $html .= '      <tbody>'."\n";
    $html .= '          <tr>'."\n";
    $html .= '              <th>房屋编号</th>'."\n";
    $html .= '              <th>租户ID</th>'."\n";
    $html .= '              <th>租户姓名</th>'."\n";
    $html .= '              <th>报表租金</th>'."\n";
    $html .= '              <th>系统租金</th>'."\n";
    $html .= '              <th>地址</th>'."\n";
    $html .= '          </tr>'."\n";


while($v = mysqli_fetch_assoc($result)){

	$assHouseID[] = $v['HouseID'];

	if($v['HousePrerent'] != $arr[$v['HouseID']]['HousePrerent']){
	
		 	$html .= ' <tr style="border-left:3px solid red;border-right:3px solid red;">'."\n";
            $html .= '              <td class="c1">' . $v['HouseID'] . '</td>'."\n";
            $html .= '              <td class="c2"></td>'."\n";
            $html .= '              <td class="c3">' . $v['TenantName'] . '</td>'."\n";
            $html .= '              <td class="c4">' . $v['HousePrerent'] . '</td>'."\n";
            $html .= '              <td class="c5">' . $arr[$v['HouseID']]['HousePrerent'] . '</td>'."\n";
            $html .= '              <td class="c6">' . $v['BanAddress'] . '</td>'."\n";
            $html .= '          </tr>'."\n";
	}
	
}

while($row2 = mysqli_fetch_assoc($result2)){
	$html .= '<tr style="border-left:3px solid green;border-right:3px solid green;">'."\n";
    $html .= '              <td class="c1"></td>'."\n";
    $html .= '              <td class="c2"></td>'."\n";
    $html .= '              <td class="c3">' . $row2['TenantName'] . '</td>'."\n";
    $html .= '              <td class="c4">' . $row2['HousePrerent'] . '</td>'."\n";
    $html .= '              <td class="c5"></td>'."\n";
    $html .= '              <td class="c6">' . $row2['BanAddress'] . '</td>'."\n";
    $html .= '          </tr>'."\n";

}


foreach($results as $vv){
	
	if(!in_array($vv['HouseID'],$assHouseID)){

		$html .= '<tr style="border-left:3px solid blue;border-right:3px solid blue;">'."\n";
	    $html .= '              <td class="c1">' . $vv['HouseID'] . '</td>'."\n";
	    $html .= '              <td class="c2"></td>'."\n";
	    $html .= '              <td class="c3">' . $vv['TenantName'] . '</td>'."\n";
	    $html .= '              <td class="c4"></td>'."\n";
	    $html .= '              <td class="c4">' . $vv['HousePrerent'] . '</td>'."\n";
	    $html .= '              <td class="c6">' . $vv['BanAddress'] . '</td>'."\n";
	    $html .= '          </tr>'."\n";

	}
}


$html .= '      </tbody>'."\n";
$html .= '  </table>'."\n";







function halt($data){
	echo '<pre>';
	var_dump($data);exit;
}


?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>赵劲涛</title>
<style>
body, td, th { font-family: "微软雅黑"; font-size: 14px; }
.warp{margin:auto; width:900px;}
.warp h3{margin:0px; padding:0px; line-height:30px; margin-top:10px;}
table { border-collapse: collapse; border: 1px solid #CCC; background: #efefef; }
table th { text-align: left; font-weight: bold; height: 26px; line-height: 26px; font-size: 14px; text-align:center; border: 1px solid #CCC; padding:5px;}
table td { height: 20px; font-size: 14px; border: 1px solid #CCC; background-color: #fff; padding:5px;}
tr{
border-bottom: 1px solid red;
}
.c1 { width: 120px; }
.c2 { width: 120px; }
.c3 { width: 150px; }
.c4 { width: 80px; text-align:center;}
.c5 { width: 80px; text-align:center;}
.c6 { width: 270px; }
</style>
</head>
<body>
<div class="warp">
<?php echo $html; ?>
</div>
</body>
</html>
