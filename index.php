<?php
   include "document.class.php";
   $document= new Document(__DIR__);
   $keyList = $document->Search("txt");
?><!DOCTYPE html>
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
    .buttons .button.active {background-color: #0894ec;color: #fff;z-index: 90;}
    .buttons .button{margin:1px}
    </style>
  </head>
  <body>
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
                      <input id="total1" type="text" placeholder="已经发布的文章数量">
                    </div>
                  </div>
                </div>
              </li>
              <li class="pub-opt">
                <div class="item-content">
                  <div class="item-inner">
                    <div class="item-title label">过去天数</div>
                    <div class="item-input">
                      <input id="passtime" type="text" placeholder="已经发布的文章分布在过去的多少天发完">
                    </div>
                  </div>
                </div>
              </li>
              <li class="pub-opt">
                <div class="item-content">
                  <div class="item-inner">
                    <div class="item-title label">未发布数量</div>
                    <div class="item-input">
                      <input id="total2" type="text" placeholder="未发布的文章数量">
                    </div>
                  </div>
                </div>
              </li>
              <li class="pub-opt">
                <div class="item-content">
                  <div class="item-inner">
                    <div class="item-title label">未来天数</div>
                    <div class="item-input">
                      <input id="futuretime" type="text" placeholder="未发布的文章将在未来多少天内发布完成">
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
$("#submit").click(function(event) {
  event.preventDefault();
  $(".modal-overlay").addClass("modal-overlay-visible");
        $(".modal").show();
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
      console.log(data);
      window.randNum = data;
      window.randLen=randNum.length;
      console.log( window.randLen );
      sub(0);
      
    }
  })
});
function sub(id){
    if (randLen == id) {
      $("#percent").text("完成！");
      setTimeout("hideModal()",500);
      return false;
    }
    $.ajax({
      url:"update.php",
      type:"post",
      data:{"id":id+1,"randNum":randNum[id]},
      success:function (data) {
        $("#percent").text("进度："+ Math.ceil(data/randLen*100)+"%");
        $(".progress-bar").width(data/randLen*100+"%");
        if (data % 10 ==0) {
          console.log( data )
        };
        sub(id+1);
      }
    })
  }
      function hideModal (){
        $(".modal-overlay").removeClass("modal-overlay-visible");
        $(".modal").hide();
      };
    </script>
  </body>
</html>