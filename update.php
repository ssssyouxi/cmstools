<?php

class MyDB extends SQLite3
   {	
   	private $path;
      function __construct($path)
      {
         $this->open($path);
      }
      public function change($a,$b){
      	 $sql ="UPDATE Content3 set ";
          if (condition) {
             $sql .= "pub_time = $b "
          }
         if (condition) {
            $sql .= "title2 = $b "
         }
         $sql .="where ID=$a";
      	//$sql ="insert into Content3 (ID,pub_time) values ($a,$b)";
      	if ($this->exec($sql)) {
      		echo $_POST['id'];
      	}     
	  }
   }
   $db=new MyDB("SpiderResult.db3");
	if($_POST){
		$db->change($_POST['id'],$_POST['randNum']);
		//echo $_POST['id'];
		//echo "success".$_POST['id'];
	}
?>