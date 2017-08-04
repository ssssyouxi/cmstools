<?php
error_reporting(0);
class MyDB extends SQLite3
   {	
   	private $path;
      function __construct($path)
      {
         $this->open($path);
      }
      public function change($a , $b = "",$c = "",$count){
        for ($i=0; $i <200 ; $i++) {
          $sql ="UPDATE Content set ";
          if ($b) {
            if($c){
             $sql .= "pub_time = $b ".",";
            }else{
              $sql .= "pub_time = $b ";
            }
          }
         if ($c) {
            $sql .= "title2 = $c ";
         }
         $sql .="where ID= $a";
         // echo "$sql";
          //$sql ="insert into Content3 (ID,pub_time) values ($a,$b)";
          $this->exec($sql);
          if ($a==$count) {
            break;
          }
          $a++;
        }
      	echo $a;
	  }
   }
   $db=new MyDB("SpiderResult.db3");
	if($_POST){
    if (!$_POST["keyfiles"]) {
      $db->change($_POST['id'],$_POST['randNum'],NULL,$_POST["count1"]);
    }else{
      $subTitle = "";
                foreach ($_POST["keyfiles"] as $value) {
                    $keyList = file(/*WEBROOT."/data/".*/$value);
                    $keyCount = count($keyList);
                    $subTitle .= $keyList[rand(0,$keyCount-1)]." " ;
                    $subTitle1="'".$subTitle."'";
                }
      $db->change($_POST['id'],$_POST['randNum'],$subTitle1,$_POST["count1"]);
    }
		

		//echo $_POST['id'];
		//echo "success".$_POST['id'];
	}
?>