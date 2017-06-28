<?php
header('Content-type: application/json');
if($_POST){
$total1=$_POST['total1'];
$total2=$_POST['total2'];
$passtime=$_POST['passtime'];
$futuretime=$_POST['futuretime'];

$start=3600*24*$passtime;
$end=3600*24*$futuretime;
for($i=0;$i<$total1;$i++){
	$pass1[]=floor(time()-mt_rand(0,$start));
	// echo date('Y-m-d H:i:s',$pass[$i],"<br/>";
	// echo $pass[$i],"<br/>";
	// echo mt_rand(1,100)/100*3600*24,"<br/>";
sort($pass1);
}


for($j=0;$j<$total2;$j++){
	$pass2[]=floor(time()+mt_rand(0,$end));
	sort($pass2);
}
$pass=array_merge($pass1,$pass2);
echo json_encode($pass);
// for($i=0;$i<$total2;$i++){
// 	$pass2[]=date('d',floor(time()-mt_rand(0,$end)));
// 	$db->change($total1,$pass1[$i],$i+1);

// }
// $arr1 = array_count_values ($pass1);
// $arr2 = array_count_values ($pass2);
// print_r($arr1);
// print_r($arr2);
}