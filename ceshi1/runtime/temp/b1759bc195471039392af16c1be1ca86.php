<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:87:"E:\phpStudy\PHPTutorial\WWW\ceshi1\public/../application/admin\view\changepassword.html";i:1529056439;}*/ ?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="renderer" content="webkit">
<meta http-equiv="Cache-Control" content="no-siteapp"/>
<title>修改密码</title>
<meta name="keywords" content="">
<meta name="description" content="">

<!--[if lt IE 9]>
<meta http-equiv="refresh" content="0;ie.html"/>
<![endif]-->

<link rel="shortcut icon" href="favicon.ico">
<link href="__CSS__/bootstrap.min.css?v=3.3.6" rel="stylesheet">
<link href="__CSS__/font-awesome.min.css?v=4.4.0" rel="stylesheet">
<link href="__CSS__/animate.min.css" rel="stylesheet">
<link href="__CSS__/style.min.css?v=4.1.0" rel="stylesheet">
</head>

<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
<div id="wrapper">
    <div class="ibox-content" style="width: 50%;height: 400px;margin: 180px auto;">
                    <form class="form-horizontal m-t" id="commentForm" method="post" action="<?php echo url('user/userpasswordedit'); ?>" style="margin-top: 70px;">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" style="text-align: center;width: 100%;    font-size: 30px;">初始密码修改</label>
                            <div style="margin-top: 100px;text-align: center;width: 100%;">
                                <input type='hidden' id='id' name='id' value="<?php echo $_SESSION['think']['id']; ?>">
                                <input id="password" type="text" class="form-control" name="password" required="" placeholder="第一次登陆必须修改密码" aria-required="true" value="" style="width:63%;display: inline;">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-8" style="text-align: center;width: 100%;margin-top: 60px;margin-left:0">
                                <button class="btn btn-primary" type="submit">确认提交</button>
                            </div>
                        </div>
                    </form>
                </div>
</div>
<script src="__JS__/jquery.min.js?v=2.1.4"></script>
<script src="__JS__/bootstrap.min.js?v=3.3.6"></script>
<script src="__JS__/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="__JS__/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="__JS__/plugins/layer/layer.min.js"></script>
<script src="__JS__/hplus.min.js?v=4.1.0"></script>
<!--<script type="text/javascript" src="__JS__/contabs.min.js"></script>-->
<script type="text/javascript" src="__JS__/contabs.js"></script>
<script src="__JS__/plugins/pace/pace.min.js"></script>
</body>

</html>
