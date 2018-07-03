<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:85:"E:\phpStudy\PHPTutorial\WWW\ceshi1\public/../application/waiter\view\index\index.html";i:1530510015;s:87:"E:\phpStudy\PHPTutorial\WWW\ceshi1\public/../application/waiter\view\public\header.html";i:1530264951;}*/ ?>
<!doctype html>
<html>
<head>
	<title>首页</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,initial-scale=1.0,maximum-scale=1.0,user-scalable=0"/>
<script src="__STATIC__/waiter/js/jquery.min.js"></script>
<script type="text/javascript" src="__STATIC__/waiter/js/buju.js"></script>
<link rel="stylesheet" type="text/css" href="__STATIC__/waiter/css/style.css"/>


	<script src="https://res.wx.qq.com/open/js/jweixin-1.3.0.js"></script>
</head>
<body>
<div class="first_page">
	<div class="head_img">
		<img src="__STATIC__/waiter/images/space.png" alt="">
	</div>

	<div class="head_title">
		<img src="__STATIC__/waiter/images/space1.png" alt="">
	</div>
	<div class="head_name">
		<?php echo $_SESSION['think']['role']; ?>
	</div>
	<div class="head_num">
		<span>工号：</span><span><?php echo $_SESSION['think']['username']; ?></span>
	</div>
	<div class="button">
		<div class="put_wine_btn">
		<a href="<?php echo url('index/waiterkeep'); ?>?cid=0&mid=1">存酒</a>
		</div>
	</div>
	<div class="button">
		<div class="get_wine_btn">
		<a href="<?php echo url('index/waiterout'); ?>">取酒</a>
		</div>
	</div>
</div>
</body>
<script>
    /*摄像头验票*/
    $('.put_wine_btn').on('click',function(){
        wx.ready(function () {
            wx.scanQRCode({
                needResult: 1,
                desc: 'scanQRCode desc',
                success: function (res) {
                    var resault = JSON.parse(JSON.stringify(res));
                    var extract_code = resault.resultStr;
                    var schedule_id = 1;
                    var url = '<?php echo url('index/checked_ticket'); ?>';
                    if(extract_code == ''){
                        return error_msg('取票码未填写');
                    }else{
                        $.post(url,{'schedule_id':schedule_id,'extract_code':extract_code},function(res){
                            var data = eval("("+res+")");
                            if(data.status == 0){
                                return error_msg(''+data.content+'');
                            }else{
                                layer.open({
                                    content: ''+data.content+'',
                                    btn: '我知道了'
                                });
                                setInterval(function(){
                                    window.location.href = '<?php echo url('index/checked_ticket'); ?>?id='+schedule_id+'&ticket_name='+data.ticket_name+'&quantity='+data.quantity+'';
                                },1000)

                            }
                        });
                    }
                }
            });
        });
    });
</script>
</html>