<?php
error_reporting(0);
class MyDB extends SQLite3
   {	
   	private $path;
      function __construct($path)
      {	 $this->path=$path;
         $this->open($path);
      }
      public function vacuum(){
      	 $sql ="VACUUM";
      	if ($this->exec($sql)) {
      		echo json_encode(["err"=>null,"msg"=>"优化文件成功"]);
      	}else{
      		echo json_encode(["err"=>"文件优化失败！"]);
      	}
	  }
   }
if(isset($_GET['db']) && !empty($_GET['db']) && file_exists(urldecode($_GET['db'])) ){
	$db=new MyDB($_GET['db']);
	$db->vacuum();
   exit();
}
if(isset($_POST['msg']) && $_POST['msg']=="start"){
	$db=new MyDB("SpiderResult.db3");
   $db->vacuum();
   exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
	<title>优化数据库</title>
</head>
<body>
<h2>请将需要优化的数据库放入<?=__DIR__?>,访问/vacuumum.php?db=数据库文件名（需要带后缀名）</h2>

</body>
</html>