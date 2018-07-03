<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:90:"E:\phpStudy\PHPTutorial\WWW\ceshi1\public/../application/waiter\view\index\waiterkeep.html";i:1530510574;s:87:"E:\phpStudy\PHPTutorial\WWW\ceshi1\public/../application/waiter\view\public\header.html";i:1530264951;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>桌号</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,initial-scale=1.0,maximum-scale=1.0,user-scalable=0"/>
<script src="__STATIC__/waiter/js/jquery.min.js"></script>
<script type="text/javascript" src="__STATIC__/waiter/js/buju.js"></script>
<link rel="stylesheet" type="text/css" href="__STATIC__/waiter/css/style.css"/>


</head>
<style>
    html,body{
        background:#1f2229;
    }
</style>
<body>
    <div class="tablenum">
        请在这里输入对应的桌位号
    </div>
    <div class="table_num">
        <ul class="num_input">
            <li>
                <input type="text" maxlength="1" name="a">
            </li>
            <li>
                <input type="text" maxlength="1" name="b">
            </li>
            <li>
                <input type="text" maxlength="1" name="c">
            </li>
            <li>
                <input type="text" maxlength="1" name="d">
            </li>
        </ul>
    </div>
    <div class="button">
        <div class="confirm_btn">
            确定
        </div>
    </div>
</body>
<script>
    $(document).ready(function(){
        $('input').eq(0).focus();
        $("input[type=text]").each(function(){
            $(this).bind('input propertychange',function(){
                if($(this).val().length >0){
                    console.log($(this).next('input').focus());
                }
            })
        });
    });
    $(".confirm_btn").click(function(){
        alert(1);
    })
</script>
</html>