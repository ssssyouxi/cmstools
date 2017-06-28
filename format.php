<?php
	
   require("document.class.php");
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

      public function change($a="ID",$b="title",$c="content"){
      	 $sql ="
		ALTER TABLE 'Content' RENAME TO '_old_Content';
		CREATE TABLE 'Content' (
		'$a'  INTEGER PRIMARY KEY AUTOINCREMENT,
		'$b'  TEXT,
		'$c' TEXT,
		'pub_time' INTEGER DEFAULT 0,
		'is_ping' DEFAULT 0
		);
		INSERT INTO 'Content' ('$a','$b','$c') SELECT `ID`,`标题`,`内容` FROM '_old_Content';
		DROP TABLE _old_Content;
		DROP TABLE DownloadFile";
	    if(!$this->exec($sql)){
	      echo $this->lastErrorMsg();
	   	}else{
            rename($this->path,"SpiderResult.db")
	   	   echo "change database successfully" ;
	   	}
	   	$this->close();
	  }
   }
   // $db=new MyDB("SpiderResult.db3");
   // if(!$db){
   //       	echo $this->lastErrorMsg();
   //       }else{
   //       	echo "open database successfully";
   //       }
   // $db->change();
   
?>