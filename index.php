<?php error_reporting(0); ?>
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
            -webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, .1);
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, .1);
        }

        .modal {
            width: 20rem;
            margin-left: -10rem;
        }

        .buttons .button.active {
            background-color: #0894ec;
            color: #fff;
            z-index: 90;
        }

        .buttons .button {
            margin: 1px
        }

        .modal .preloader {
            margin: 0 auto
        }
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
                                            <input id="total1" type="text" placeholder="已经发布的文章数量" onKeypress="return (/[\d.]/.test(Math.ceil(String.fromCharCode(event.keyCode))))">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="pub-opt">
                                <div class="item-content">
                                    <div class="item-inner">
                                        <div class="item-title label">过去天数</div>
                                        <div class="item-input">
                                            <input id="passtime" type="text" placeholder="已经发布的文章分布在过去的多少天发完" onKeypress="return (/[\d.]/.test(Math.ceil(String.fromCharCode(event.keyCode))))">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="pub-opt">
                                <div class="item-content">
                                    <div class="item-inner">
                                        <div class="item-title label">未发布数量</div>
                                        <div class="item-input">
                                            <input id="total2" type="text" placeholder="未发布的文章数量" onKeypress="return (/[\d.]/.test(Math.ceil(String.fromCharCode(event.keyCode))))">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="pub-opt">
                                <div class="item-content">
                                    <div class="item-inner">
                                        <div class="item-title label">未来天数</div>
                                        <div class="item-input">
                                            <input id="futuretime" type="text" placeholder="未发布的文章将在未来多少天内发布完成" onKeypress="return (/[\d.]/.test(Math.ceil(String.fromCharCode(event.keyCode))))">
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
                                    <p class="buttons-row" style="margin:0;">
                                        <?php 
                                        if(is_array($keyList) && !empty($keyList)){
                                        foreach ($keyList as $value){ 
                                        ?>
                                        <a href="#" class="button select-key-files"><?=$value?></a>
                                        <?php } 
                                        }else{
                                        ?> 请先将附加关键词文件放入
                                                            <?=__DIR__?>目录中
                                                                <?php
                                        }
                                        ?>
                                    </p>
                                </div>
                            </li>
                            <li class="division-switch">
                                <div class="item-content">
                                    <div class="item-inner">
                                        <div class="item-title label">是否分割数据</div>
                                        <div class="item-input">
                                            <label class="label-switch">
                        <input value="1" id="divTimeSwitch" type="checkbox">
                        <div class="checkbox"></div>
                      </label>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="division-opt1">
                                <div class="item-content">
                                    <div class="item-inner">
                                        <div class="item-title label">每份文章数量</div>
                                        <div class="item-input">
                                            <input id="everydb" type="text" placeholder="每份文章数量" onKeypress="return (/[\d.]/.test(Math.ceil(String.fromCharCode(event.keyCode))))">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="division-opt2">
                                <div class="item-content">
                                    <div class="item-inner">
                                        <div class="item-title label">分割个数</div>
                                        <div class="item-input">
                                            <input id="dbcount" type="text" placeholder="分割成多少个数据库" onKeypress="return (/[\d.]/.test(Math.ceil(String.fromCharCode(event.keyCode))))">
                                        </div>
                                    </div>
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
                    if ($("#keywordFileSwitch:checked").val()) {
                        $(".keyword-files").hide();
                    } else {
                        $(".keyword-files").show();
                    }
                });
                $(".pub-opt").hide();
                $(".pub-switch .checkbox").click(function (e) {
                    if ($("#pubTimeSwitch:checked").val()) {
                        $(".pub-opt").hide();
                    } else {
                        $(".pub-opt").show();
                    }

                });
                $(".division-opt1,.division-opt2").hide();
                $(".division-switch .checkbox").click(function (e) {
                    if ($("#divTimeSwitch:checked").val()) {
                        $(".division-opt1,.division-opt2").hide();
                    } else {
                        $(".division-opt1,.division-opt2").show();
                    }
                });
                // 选取附加关键词文件
                $(".select-key-files").click(function (e) {
                    e.preventDefault();
                    if ($(this).hasClass("active")) {
                        $(this).removeClass("active");
                        var val = $("#keywordFilesName").val();
                        val = val.replace($.trim($(this).html()), "");
                        $("#keywordFilesName").val($.trim(val));
                    } else {
                        $(this).addClass("active");
                        $("#keywordFilesName").val($.trim($("#keywordFilesName").val() + " " + $(this).html()));
                    }

                });
                //分割计算
                $("#everydb").keyup(function () {
                    if ($("#everydb").val()) {
                        var countdb = Math.ceil(<?=$count?> / $("#everydb").val());
                        $("#dbcount").val(countdb);
                    } else {
                        $("#dbcount").val("");
                    }
                })
                $("#dbcount").keyup(function () {
                    if ($("#dbcount").val()) {
                        var everydb = Math.ceil(<?=$count?> / $("#dbcount").val());
                        $("#everydb").val(everydb);
                    } else {
                        $("#everydb").val("");
                    }
                })
                //自动填入剩余数量
                $("#total1").keyup(function () {

                    if (<?=$count?> - $("#total1").val() < 0) {
                        $("#total1").val(<?=$count?>);
                        $("#total2").val("");
                    } else {
                        $("#total2").val(<?=$count?> - $('#total1').val());
                    }
                })
                $("#total2").keyup(function () {
                    if (<?=$count?> - $("#total1").val() < 0) {
                        $("#total2").val(<?=$count?>);
                        $("#total1").val("");
                    } else {
                        $("#total1").val(<?=$count?> - $('#total2').val());
                    }
                })
            });
            $("#submit").click(function (event) {
                event.preventDefault();
                //表单验证
                if ($("#divTimeSwitch:checked").val() && ($("#everydb").val() == "" || $("#dbcount").val()<2 )) {
                    alert("请填写正确的内容或关闭“是否分割数据”！");
                    return false;
                }

                if ($("#pubTimeSwitch:checked").val()) {
                    if ($("#total1").val() == "" ^ $("#passtime").val() == "" || $("#total2").val() == "" ^ $("#futuretime").val() == "" || ($("#total1").val() == "" && $("#passtime").val() == "" && $("#total2").val() == "" && $("#futuretime").val() == "")) {
                        alert("请填写内容或关闭“是否随机时间”！");
                        return false;
                    }
                }
                if ($("#keywordFileSwitch:checked").val() != undefined && $("#keywordFilesName").val() == "") {
                    alert("请选择文件或关闭“附加关键词”！");
                    return false;
                }
                //显示消息框
                $(".progress,#percent").hide();
                $(".modal-overlay").addClass("modal-overlay-visible");
                $(".modal").show();
                //整理数据库
                Sub.formatDb(function () { 
                    
                    if ($("#pubTimeSwitch:checked").val() === undefined && $("#keywordFileSwitch:checked").val() === undefined && $("#divTimeSwitch:checked").val() === undefined) {
                        //如果不需要随机时间、分割数据库、附加关键词，直接完成操作
                        Sub.modDbName();
                    }else{
                        //处理次数
                        var cirCount =Math.ceil(<?=$count?>/2000);
                        //循环处理
                        Sub.recurProcess(0,cirCount,function () {
                            if ($("#divTimeSwitch:checked").val()) {
                                Sub.divDb(0);
                            }else{
                                Sub.orderByPub(function () {
                                    Sub.modDbName();
                                });                 
                            }
                        })    
                    }
                })
            });
            var date = new Date();
            window.dbDir = date.getFullYear() + "-" + date.getMonth() + "-" + date.getDate() + "_" + date.getHours() + "-" + date.getMinutes() + "-" + date.getSeconds();
            var Sub = {
                formatDb : function (success_func) {
                    $(".modal-title").text("正在转换表结构……");
                    $.post("format.php", {"trans":true},
                        function (data) {
                            if(data.err){
                                alert(data.err);
                                return false;
                            }else{
                                $(".modal-title").text("正在清理无用表……");
                                $.post("format.php", {"vacuum":true},
                                    function (data) {
                                        if(data.err){
                                            alert(data.err);
                                            return false;
                                        }else{
                                            $(".modal-title").text("数据库结构整理完成");
                                            success_func();
                                        }
                                    }
                                );
                                
                            }
                        }
                    );
                },
                //修改数据库名
                modDbName : function () {
                    $.post('./rename.php', {
                        "rename": 'db'
                    }, function (data) {
                        if (data.err) {
                            $(".modal").removeClass("modal-no-buttons").html(
                                '<div class="modal-inner"><div class="modal-text">' + data.err +
                                '</div></div><div class="modal-buttons "><span class="modal-button modal-button-bold">确定</span></div>'
                            );
                            $(".modal-button").click(function () {
                                $(".modal-overlay").removeClass("modal-overlay-visible");
                                $(".modal").hide();
                            });
                        } else {
                            $(".modal").removeClass("modal-no-buttons").html(
                                '<div class="modal-inner"><div class="modal-text">' + data.msg +
                                '</div></div><div class="modal-buttons "><span class="modal-button modal-button-bold">确定</span></div>'
                            );
                            $(".modal-button").click(function () {
                                $(".modal-overlay").removeClass("modal-overlay-visible");
                                $(".modal").hide();
                            });
                        }
                    })
                },
                //递归提交处理数据
                recurProcess : function (currentNum,cirCount,success_func) {
                    if ($("#pubTimeSwitch:checked").val() === undefined && $("#keywordFileSwitch:checked").val() === undefined ){
                        success_func();
                    }else{
                        $(".modal-title").text("正在处理数据库……");
                        if (currentNum == cirCount) {
                            success_func();
                            return false;
                        }
                        //提交数据
                        var subData = {
                            "totalCount" : <?=$count?>,
                            "currentNum" : currentNum,
                            "isRandTime" : false,
                            "isKeyword"  : false
                        };

                        //附加关键词
                        if ($("#keywordFileSwitch:checked").val()) {
                            subData.keywordFile = $("#keywordFilesName").val() == "" ? null : $("#keywordFilesName").val().split(" ");
                            subData.isKeyword = true;                         
                        }
                        //随机时间
                        if ($("#pubTimeSwitch:checked").val()) {
                            subData.isRandTime = true; 
                            subData.total1 = $("#total1").val();
                            subData.total2 = $("#total2").val();
                            subData.passtime = $("#passtime").val();
                            subData.futuretime = $("#futuretime").val();
                        }
                        $.post("./data.php", subData,
                            function (data) {
                                if (data.err) {
                                    $(".modal").removeClass("modal-no-buttons").html(
                                        '<div class="modal-inner"><div class="modal-text">' + data.err +
                                        '</div></div><div class="modal-buttons "><span class="modal-button modal-button-bold">确定</span></div>'
                                    );
                                    $(".modal-button").click(function () {
                                        $(".modal-overlay").removeClass("modal-overlay-visible");
                                        $(".modal").hide();
                                    });
                                }else{
                                    $("#percent").show().text("进度：" + Math.ceil( currentNum*2000 / <?=$count?> * 100) + "%" );
                                    $(".progress,#percent").show();
                                    $(".progress-bar").show().width( currentNum*2000 / <?=$count?> * 100 + "%" );
                                    currentNum++;
                                    Sub.recurProcess(currentNum,cirCount,success_func);
                                }
                            }
                        );
                    }
                },
                //时间排序
                orderByPub : function (success_func) {
                    if ($("#pubTimeSwitch:checked").val()) {
                        $(".modal-title").text("正在排序……");
                        $(".progress,#percent").hide();
                        $(".modal-overlay").addClass("modal-overlay-visible");
                        $(".modal").show();
                        $.post("./data.php", {"order":true,"isRandTime" : false,"isKeyword"  : false},
                            function (data) {
                                success_func();
                            }
                        );
                    }else{
                        success_func()
                    }
                    
                },
                //分割数据库
                divDb : function (currentDB) {
                    if (currentDB == $("#dbcount").val()) {
                        $(".modal").removeClass("modal-no-buttons").html(
                                '<div class="modal-inner"><div class="modal-text">处理完毕,分割后的数据保存在目录：<br>'+dbDir+'</div></div><div class="modal-buttons "><span class="modal-button modal-button-bold">确定</span></div>'
                            );
                        $(".modal-button").click(function () {
                                $(".modal-overlay").removeClass("modal-overlay-visible");
                                $(".modal").hide();
                            });
                        return false;
                    }
                    $(".modal-title").text("正在分割数据库……");
                    $.post("./data.php", {"currentDB":currentDB,"dbDir":dbDir,"everydb":$("#everydb").val(),"dbcount":$("#dbcount").val()},
                        function (data) {
                            currentDB++;
                            $("#percent").show().text("进度：" + Math.ceil( currentDB /$("#dbcount").val()  * 100) + "%" );
                            $(".progress,#percent").show();
                            $(".progress-bar").show().width( currentDB / $("#dbcount").val() * 100 + "%" );
                            Sub.divDb(currentDB);
                        }
                    );
                }
            }
            
        </script>
</body>

</html>