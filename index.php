<?php
error_reporting(0);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>数据库处理</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <link rel="stylesheet" href="https://g.alicdn.com/msui/sm/0.6.2/css/sm.min.css">
    <link rel="stylesheet" href="https://g.alicdn.com/msui/sm/0.6.2/css/sm-extend.min.css">
    <style>
    .progress-bar {
          color: #fff;
          float: left;
          background-color: #0a0;
          display: inline-block;
          font-size: 12px;
          line-height: 14px;
          text-align: center;
      }
      .progress .progress-bar:last-child {
          border-radius: 0 7px 7px 0;
      }
      .progress {
          height: 14px;
          overflow: hidden;
          background-color: #f5f5f5;
          border-radius: 7px;
          -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
          box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
      }
      .modal{width: 20rem;margin-left: -10rem;}
    .buttons .button.active {background-color: #0894ec;color: #fff;z-index: 90;}
    .buttons .button{margin:1px}
    .modal .preloader {margin: 0 auto}
    </style>
  </head>
  <body>
  <?php
    if(!file_exists("SpiderResult.db3")){
          exit("请放入文件SpiderResult.db3！");
       }
     include "document.class.php";
     $document= new Document(__DIR__);
     $keyList = $document->Search("txt");
     
     $db = new SQLite3("SpiderResult.db3");
     $sql = "SELECT count(ID) FROM Content";
     // $sql="select * from Content";
    $count = $db->querySingle($sql);
    if(empty($count)){
        exit("请放入正确的SpiderResult.db3！");
    }
     // $count = $db->exec($sql);
  ?>
    <div class="page-group">
        <div class="page page-current" style="max-width: 760px;margin: 0 auto;">
        <header class="bar bar-nav">
          <h1 class='title'>数据库处理</h1>
        </header>
        <div class="content">
          <div class="list-block">
            <ul>
              <!-- Text inputs -->
              <li class="pub-switch">
                <div class="item-content">
                  <div class="item-inner">
                    <div class="item-title label">是否随机时间</div>
                    <div class="item-input">
                      <label class="label-switch">
                        <input value="1" id="pubTimeSwitch" type="checkbox">
                        <div class="checkbox"></div>
                      </label>
                    </div>
                  </div>
                </div>
              </li>
              <li class="pub-opt">
                <div class="item-content">
                  <div class="item-inner">
                    <div class="item-title label">已发布数量</div>
                    <div class="item-input">
                      <input id="total1"  type="text" placeholder="已经发布的文章数量" onKeypress="return (/[\d.]/.test(String.fromCharCode(event.keyCode)))">
                    </div>
                  </div>
                </div>
              </li>
              <li class="pub-opt">
                <div class="item-content">
                  <div class="item-inner">
                    <div class="item-title label">过去天数</div>
                    <div class="item-input">
                      <input id="passtime" type="text" placeholder="已经发布的文章分布在过去的多少天发完" onKeypress="return (/[\d.]/.test(String.fromCharCode(event.keyCode)))">
                    </div>
                  </div>
                </div>
              </li>
              <li class="pub-opt">
                <div class="item-content">
                  <div class="item-inner">
                    <div class="item-title label">未发布数量</div>
                    <div class="item-input">
                      <input id="total2" type="text" placeholder="未发布的文章数量" onKeypress="return (/[\d.]/.test(String.fromCharCode(event.keyCode)))">
                    </div>
                  </div>
                </div>
              </li>
              <li class="pub-opt">
                <div class="item-content">
                  <div class="item-inner">
                    <div class="item-title label">未来天数</div>
                    <div class="item-input">
                      <input id="futuretime" type="text" placeholder="未发布的文章将在未来多少天内发布完成" onKeypress="return (/[\d.]/.test(String.fromCharCode(event.keyCode)))">
                    </div>
                  </div>
                </div>
              </li>
              <li class="keyword-switch">
                <div class="item-content">
                  <div class="item-inner">
                    <div class="item-title label">附加关键词</div>
                    <div class="item-input">
                      <label class="label-switch">
                        <input value="1" id="keywordFileSwitch" type="checkbox">
                        <div class="checkbox"></div>
                      </label>
                    </div>
                  </div>
                </div>
              </li>
              <li class="keyword-files">
                <div class="item-content">
                  <div class="item-inner">
                    <div class="item-title label">附加文件</div>
                    <div class="item-input">
                      <input id="keywordFilesName" type="text" placeholder="附加关键词文件，点击下面选取，注意顺序">
                    </div>
                  </div>
                </div>
                <div class="content-block" style="margin:0;padding-bottom: 5px">
                  <p class="buttons-row"  style="margin:0;">
                    <?php 
                    if(is_array($keyList) && !empty($keyList)){
                      foreach ($keyList as $value){ 
                    ?>
                    <a href="#" class="button select-key-files"><?=$value?></a>
                    <?php } 
                    }else{
                    ?>
                    请先将附加关键词文件放入<?=__DIR__?>目录中
                    <?php
                    }
                    ?>
                  </p>
                </div>
              </li>
            </ul>
          </div>
          <div class="content-block">
            <div class="row">
              <div class="col-50"><a id="submit" href="#" class="button button-big button-fill button-success">提交</a></div>
              <div class="col-50"><a href="#" class="button button-big button-fill button-danger">取消</a></div>
            </div>
          </div>
        </div>
        </div>
        <div class="modal modal-no-buttons modal-in" style="margin-top: -78px;">
          <div class="modal-inner">
            <div class="modal-title">正在生成数据库</div>
            <div class="modal-text">
                <div class="progress">
                           <div class="progress-bar" style="width: 50%;">
                              &nbsp;</div>
                  
                        </div>
                <p id="percent">进度：0%</p>
                <div class="preloader"></div>
            </div>
          </div>
          <div class="modal-buttons "></div>
        </div>
        <div class="modal-overlay"></div>
    </div>

    <script type='text/javascript' src='https://g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='https://g.alicdn.com/msui/sm/0.6.2/js/sm.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='https://g.alicdn.com/msui/sm/0.6.2/js/sm-extend.min.js' charset='utf-8'></script>
    <script>
      $(function () {
        // 显示/隐藏
        $(".keyword-files").hide();
        $(".keyword-switch .checkbox").click(function (e) { 
          if($("#keywordFileSwitch:checked").val()){
            $(".keyword-files").hide();
          }else{
            $(".keyword-files").show();
          }
        });

 
        $(".pub-opt").hide();
        $(".pub-switch .checkbox").click(function (e) { 
          if($("#pubTimeSwitch:checked").val()){
            $(".pub-opt").hide();
          }else{
            $(".pub-opt").show();
          }
        });
        // 选取附加关键词文件
        $(".select-key-files").click(function (e) { 
          e.preventDefault();
          if ($(this).hasClass("active")) {
            $(this).removeClass("active");
            var val = $("#keywordFilesName").val();
            val = val.replace($.trim($(this).html()),"");
            $("#keywordFilesName").val($.trim(val));
          }else{
            $(this).addClass("active");
            $("#keywordFilesName").val($.trim($("#keywordFilesName").val()+" "+$(this).html()));
          }
          
        });
        
      });
//自动填入剩余数量
$("#total1").keyup(function(){

 if(<?=$count?>-$("#total1").val()<0){
  $("#total1").val(<?=$count?>);
  $("#total2").val("");
  }else{
    $("#total2").val(<?=$count?>-$('#total1').val());
  }
})
$("#total2").keyup(function(){

 if(<?=$count?>-$("#total1").val()<0){
  $("#total2").val(<?=$count?>);
  $("#total1").val("");
  }else{
    $("#total1").val(<?=$count?>-$('#total2').val());
  }
})
$("#submit").click(function(event) {
  window.count1= $("#pubTimeSwitch:checked").val()===undefined ?  <?=$count?>: parseInt($("#total1").val())+parseInt($("#total2").val());
    $(".progress,#percent").hide();
    event.preventDefault();
    if($("#pubTimeSwitch:checked").val()){
      if($("#total1").val()=="" ^ $("#passtime").val()=="" || $("#total2").val()=="" ^ $("#futuretime").val()==""||($("#total1").val()=="" && $("#passtime").val()=="" && $("#total2").val()=="" && $("#futuretime").val()=="")){
        alert("请填写内容或关闭“是否随机时间”！");
      return false;
      }
    }
    if($("#keywordFileSwitch:checked").val()!=undefined && $("#keywordFilesName").val()==""){
      alert("请选择文件或关闭“附加关键词”！");
      return false;
    }
    $(".modal-overlay").addClass("modal-overlay-visible");
    $(".modal").show();
    window.keyfiles = $("#keywordFilesName").val()=="" ? null : $("#keywordFilesName").val().split(" ");
    $.ajax({
        url: 'format.php',
        type: 'POST',
        success: function(data) {
            if (data == "数据库生成完成！") {
                $(".modal-title").text(data);
                if ($("#pubTimeSwitch:checked").val()) {
                    setTimeout("getRand()", 500);
                }else if($("#keywordFileSwitch:checked").val()!=undefined){
                  window.randNum=[];
                  $(".preloader").hide();
                  $(".modal-title").text("正在随机添加关键词……");
                  sub(0);
                 
            }else{
                  // console.log(data);
                 $(".preloader").hide();
                 setTimeout("hideModal()", 500);
            }
            }else{
              alert(data);
              return false;
            } 
        }
    })
})
;

function getRand(){
  $(".modal-title").text("正在生成随机数，请稍后……");
   $(".preloader").show();
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
      // console.log(data);
      window.randNum = data;
      window.randLen=randNum.length;
      // console.log( window.randLen );
      $(".modal-title").text("正在修改数据库……");
      $(".preloader").hide();
      setTimeout("sub(0)",500);
      
    }
  })
}

function sub(id){
    if (count1 == id) {
      $("#percent").text("完成！");
      setTimeout("hideModal()",500);
      return false;
    }
    $.ajax({
      url:"update.php",
      type:"post",
      data:{"id":id+1,"randNum":randNum[id],"keyfiles":keyfiles},
      success:function (data) {
          // console.log(data);
        $("#percent").show().text("进度："+ Math.ceil(data/count1*100)+"%");
        // console.log("第"+data+"计算结果："+ data+"/"+ count1 + "=" +data/count1);
        $(".progress,#percent").show();
        $(".progress-bar").show().width(data/count1*100+"%");
        // if (data % 10 ==0) {
        //  console.log( data )
        // };
        sub(id+1);
      }
    })
  }
      function hideModal (){
        /*$(".modal-overlay").removeClass("modal-overlay-visible");
        $(".modal").hide();*/
        $(".modal-title").text("正在优化数据表，请稍后……");
        $(".preloader").show();
        $.post('./vacuum.php',{"msg":'start'},function(data){
          $(".preloader").hide();
          if(data.err){
             $(".modal-title").text( data.err);
          }else{
           $.post('./rename.php', {"rename": 'db'}, function(data) {
            if (data.err) {
              $(".modal").removeClass("modal-no-buttons").html('<div class="modal-inner"><div class="modal-text">'+data.err+'</div></div><div class="modal-buttons "><span class="modal-button modal-button-bold">确定</span></div>'); 
              $(".modal-button").click(function(){$(".modal-overlay").removeClass("modal-overlay-visible");$(".modal").hide();});
            }else{
              $(".modal").removeClass("modal-no-buttons").html('<div class="modal-inner"><div class="modal-text">'+data.msg+'</div></div><div class="modal-buttons "><span class="modal-button modal-button-bold">确定</span></div>'); 
              $(".modal-button").click(function(){$(".modal-overlay").removeClass("modal-overlay-visible");$(".modal").hide();});
            }
          })
        }
       })
      };
    </script>
  </body>
</html>