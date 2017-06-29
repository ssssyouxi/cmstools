<?php
header('Content-type: application/json');
if ($_POST["rename"]="db") {
	if (rename("SpiderResult.db3","SpiderResult.db")) {
		echo json_encode(["err"=>null,"msg"=>"自动修改后缀名成功"]);
	}else{
		echo json_encode(["err"=>"后缀名修改失败，请自行将数据库后缀名修改为.db"]);
	}
}
?>