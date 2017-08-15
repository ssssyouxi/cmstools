<?php
error_reporting(0);

try{
	$dbh=new PDO('sqlite:SpiderResult.db3');
}
catch(PDOException $e){
	exit(["err"=>"无法连接到数据库"]);
}

//转换数据库
if(isset($_POST["trans"]) && $_POST["trans"]){
	$sql ="
	ALTER TABLE 'Content' RENAME TO '_old_Content';
	CREATE TABLE 'Content' (
		'ID'  INTEGER PRIMARY KEY AUTOINCREMENT,
		'title'  TEXT,
		'content' TEXT,
		'title2' TEXT,
		'pub_time' INTEGER DEFAULT 0,
		'is_ping' DEFAULT 0
	);
	INSERT INTO 'Content' (`title`,`content`) SELECT `标题`,`内容` FROM '_old_Content' ORDER BY random();
	";
	try {
		$dbh->beginTransaction();
		$dbh->exec($sql);
		$dbh->commit();
		echo json_encode(["err"=>null,"msg"=>"结构转换完毕"]);
	}
	catch(PDOException $e){
		$dbh->rollBack();
		echo json_encode(["err"=>"写入失败"]) ;
	}
}
//清理无用数据
if(isset($_POST["vacuum"]) && $_POST["vacuum"]){
	$sql = "
	DROP TABLE _old_Content;
	DROP TABLE DownloadFile;
	VACUUM;
	";
	try {
		$dbh->beginTransaction();
		$dbh->exec($sql);
		$dbh->commit();
		echo json_encode(["err"=>null,"msg"=>"清理完毕"]);
	}
	catch(PDOException $e){
		$dbh->rollBack();
		echo json_encode(["err"=>"清理失败"]) ;
	}	
}