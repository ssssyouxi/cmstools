<?php
error_reporting(0);
header('Content-type: application/json');
if ($_POST["rename"]="db") {
	$name=date("Y-m-d-H-i-s").".db";
	if (rename("SpiderResult.db3",$name)) {
		echo json_encode(["err"=>null,"msg"=>"数据处理成功！处理后的数据库文件名称为<br/>\n".$name]);
	}else{
		echo json_encode(["err"=>"后缀名修改失败，请自行将数据库后缀名修改为.db"]);
	}
}
?>