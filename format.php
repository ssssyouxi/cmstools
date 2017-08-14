<?php
	error_reporting(0);
   class MyDB extends SQLite3
   {	
   	  private $path;
      function __construct($path)
      {
         $this->path=$path;
         $this->open($path);
      }

      public function sql($sql){
      	$ret = $this->exec($sql);
   		if(!$ret){
      		echo $this->lastErrorMsg();
   		}
      }

      public function change(){
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
		DROP TABLE _old_Content;
		VACUUM;
		";
		
	    if(!$this->exec($sql)){
	      	echo json_encode(["err"=>$this->lastErrorMsg()]) ;
	   	}else{
            $sql="SELECT name FROM sqlite_master WHERE name='DownloadFile' ";
            if($this->exec($sql)){
               $sql="DROP TABLE DownloadFile";
               $this->exec($sql);
            }
            $this->close();
			echo json_encode(["err"=>null,"msg"=>"数据库生成完成！"]) ;
	   	}	
	  }
   }
   $db=new MyDB("SpiderResult.db3");
   if(!$db){
         	echo json_encode(["err"=>$this->lastErrorMsg()]) ;
         }
   $db->change();
   
?>