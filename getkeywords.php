<?php
header('Content-type: application/json');
if($_POST){
	$arr=$_POST["keywordFilesName"];
	$res = explode(" ", $arr);
 				$subTitle = "";
                foreach ($res as $value) {
                    $keyList = file(WEBROOT."/data/".$value);
                    $keyCount = count($keyList);
                    $subTitle .= $keyList[rand(0,$keyCount-1)];
                }
echo json_encode($subTitle);

}