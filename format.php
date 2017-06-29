<?php
	
   class MyDB extends SQLite3
   {	
   	  private $path;
      function __construct($path)
      {
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
		CREATE TABLE 'Content4' (
		'ID'  INTEGER PRIMARY KEY AUTOINCREMENT,
		'title'  TEXT,
		'content' TEXT,
      'title2' TEXT,
		'pub_time' INTEGER DEFAULT 0,
		'is_ping' DEFAULT 0
		);
		INSERT INTO 'Content4' (`ID`,`title`,`content`) SELECT `ID`,`标题`,`内容` FROM '_old_Content';
		DROP TABLE _old_Content;
		DROP TABLE DownloadFile";
	    if(!$this->exec($sql)){
	      echo $this->lastErrorMsg();
	   	}else{
            // rename($this->path,"SpiderResult.db");
            
	   	   echo "数据库生成完成！" ;
	   	}
	   	$this->close();
	  }
   }
   $db=new MyDB("SpiderResult.db3");
   if(!$db){
         	echo $this->lastErrorMsg();
         }
   $db->change();
   
?>