<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:85:"E:\phpStudy\PHPTutorial\WWW\ceshi1\public/../application/waiter\view\login\login.html";i:1530498943;s:87:"E:\phpStudy\PHPTutorial\WWW\ceshi1\public/../application/waiter\view\public\header.html";i:1530264951;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>登录</title>
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
<div class="login_title">
    登录验证
</div>
<div class="login_con">
    请输入你的工号进行验证
</div>
<div class="login_input">
    <div class="login_name">
        <div class="login_intro">
            工号
        </div>
        <div class="login_num">
            <input type="text" placeholder="请输入你的工号" id='user_name'>
        </div>
    </div>
</div>
<div class="login_input" style="margin-bottom:1.88rem;">
    <div class="login_name">
        <div class="login_intro">
            密码
        </div>
        <div class="login_num">
            <input type="password" placeholder="请输入你的密码" id='password'>
        </div>
        <p class="m-t-md" id="err_msg"></p>
    </div>
</div>

<div class="login_input">
    <div class="login_name select" style="display: flex;justify-content: center;align-items: center;color:#fff;font-size: 0.36rem;" id='login_btn'>
      登录
    </div>
</div>
<div></div>
<script>
    var lock = false;
    $(function () {
        $('#login_btn').click(function(){
            if(lock){
                return;
            }
            lock = true;
            $('#err_msg').hide();
            $('#login_btn').removeClass('btn-success').addClass('btn-danger').val('登陆中...');
            var username = $('#user_name').val();
            var password = $('#password').val();
            $.post("<?php echo url('login/doLogin'); ?>",{'user_name':username, 'password':password},function(data){
                lock = false;
                $('#login_btn').val('登录').removeClass('btn-danger').addClass('btn-success');
                if(data.code!=1){
                    $('#err_msg').show().html("<span style='color:red'>"+data.msg+"</span>");
                    return;
                }else{
                    window.location.href=data.data;
                }
            });
        });
    });
</script>
</body>
</html>