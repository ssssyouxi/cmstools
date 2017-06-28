<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script type="text/javascript" src="jquery.js"></script>
</head>
<body>

	<span>向前个数：</span><input type="text" id="total1"><br/>
	<span>向前天数：</span><input type="text" id="passtime"><br/>
	<span>向后个数：</span><input type="text" id="total2"><br/>
	<span>向后天数：</span><input type="text" id="futuretime"><br/>
	<input id="submit" type="button" value=" 提交"/>

</body>
<script>
$(function(){
	$("#submit").click(function(event) {
		event.preventDefault();
		$.ajax({
			url: 'getrand.php',
			type: 'POST',
			dataType: 'json',
			data:{
				"total1":$("#total1").val(),
				"passtime":$("#passtime").val(),
				"total2":$("#total2").val(),
				"futuretime":$("#futuretime").val()
			},
			success:function  (data) {
				window.randNum = data;
				window.randLen=randNum.length;
				console.log( window.randLen );
				sub(0);
				hideModal();
			}
		})
	});
});
	

	function sub(id){
		if (randLen == id) {
			return false;
		}
		$.ajax({
			url:"update.php",
			type:"post",
			data:{"id":id+1,"randNum":randNum[id]},
			success:function (data) {
				if (data % 10 ==0) {
					console.log( data )
				};
				sub(id+1);
			}
		})
	}
</script>
</html>