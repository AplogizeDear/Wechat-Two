<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:91:"E:\phpStudy\PHPTutorial\WWW\ceshi1\public/../application/admin\view\keepout\outexamine.html";i:1528701491;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>取酒审核</title>
    <link rel="shortcut icon" href="favicon.ico">
    <link href="__CSS__/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="__CSS__/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="__CSS__/animate.min.css" rel="stylesheet">
    <link href="__CSS__/style.min.css?v=4.1.0" rel="stylesheet">
    <link href="__JS__/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">
    <link href="__JS__/layui/css/layui.css"rel="stylesheet">
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-10">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>取酒审核</h5>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal m-t" id="commentForm" method="post" action="<?php echo url('keepout/outExamine'); ?>">
                        <input  type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">用户：</label>
                            <div class="input-group col-sm-7">
                                <select name="mid" class="form-control" id="mid">  
                                            <option value="<?php echo $info['m_id']; ?>"><?php echo $info['nickname']; ?></option>  
                                </select>  
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">服务员：</label>
                            <div class="input-group col-sm-7">
                                <select name="wid" class="form-control">  
                                            <option value="<?php echo $info['w_id']; ?>"><?php echo $info['w_name']; ?></option>  
                                        </select>  
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">桌台：</label>
                            <div class="input-group col-sm-7">
                                <select name="sid" class="form-control">  
                                            <option value="<?php echo $info['s_id']; ?>"><?php echo $info['seat']; ?></option>  
                                        </select>
                            </div>
                        </div>
                        <div class="form-group" id="recharge">
                            <?php if(is_array($infos) || $infos instanceof \think\Collection || $infos instanceof \think\Paginator): $i = 0; $__LIST__ = $infos;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                                <div class="input-group col-sm-7 recharge_s" style="width: 100%" >
                                        <label class="col-sm-3 control-label" style="width:12%">酒种类</label>
                                        <select name="tid_<?php echo $key; ?>" id="tid_<?php echo $key; ?>" class="form-control" style="width:10%" >  
                                            <option value="<?php echo $v['t_id']; ?>"><?php echo $v['type']; ?></option>  
                                        </select>
                                        <label class="col-sm-3 control-label" style="width:10%">酒品牌</label>
                                        <select name="bid_<?php echo $key; ?>" id="bid_<?php echo $key; ?>" class="form-control" style="width:10%">  
                                            <option value="<?php echo $v['b_id']; ?>"><?php echo $v['type']; ?></option>  
                                        </select>
                                        <label class="col-sm-3 control-label" style="width:7%">数量</label>
                                        <input id="num_<?php echo $key; ?>" type="text" class="form-control" name="num_<?php echo $key; ?>" required="" aria-required="true" value="<?php echo $v['num']; ?>" style="width:10%" readonly="readonly" >
                                        <label class="col-sm-3 control-label" style="width:7%">小数</label>
                                        <select name="nums_<?php echo $key; ?>" class="form-control" id="nums_<?php echo $key; ?>" style="width:10%">  
                                            <option value="<?php echo $v['nums']; ?>"><?php echo $v['nums']; ?>/10</option>  
                                        </select>
                                        <label class='col-sm-3 control-label' style='width:10%'>有效时间</label>
                                        <input id='useday_<?php echo $key; ?>' type='text' class='form-control' name='useday_<?php echo $key; ?>' required='' aria-required='true' value="<?php echo $v['use_day']; ?>" style='width:9%' readonly="readonly" >
                                    </div>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                         </div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-8">
                                <!--<input type="button" value="提交" class="btn btn-primary" id="postform"/>-->
                                <button class="btn btn-primary" type="submit">确认提交</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
    
<script src="__JS__/jquery.min.js?v=2.1.4"></script>
<script src="__JS__/bootstrap.min.js?v=3.3.6"></script>
<script src="__JS__/content.min.js?v=1.0.0"></script>
<script src="__JS__/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<script src="__JS__/plugins/validate/jquery.validate.min.js"></script>
<script src="__JS__/plugins/validate/messages_zh.min.js"></script>
<script src="__JS__/layui/layui.js"></script>
<script src="__JS__/jquery.form.js"></script>
<script src="__JS__/plugins/ueditor/ueditor.config.js"></script>
<script src="__JS__/plugins/ueditor/ueditor.all.js"></script>
<script type="text/javascript">

    var index = '';
    function showStart(){
        index = layer.load(0, {shade: false});
        return true;
    }

    function showSuccess(res){

        layer.ready(function(){
            layer.close(index);
            if(1 == res.code){
                layer.alert(res.msg, {title: '友情提示', icon: 1, closeBtn: 0}, function(){
                    window.location.href = res.data;
                });
            }else if(111 == res.code){
                window.location.reload();
            }else{
                layer.msg(res.msg, {anim: 6});
            }
        });
    }

    $(document).ready(function(){
        // 添加角色
        var options = {
            beforeSubmit:showStart,
            success:showSuccess
        };

        $('#commentForm').submit(function(){
            $(this).ajaxSubmit(options);
            return false;
        });

        $('#keywords').tagsinput('add', 'some tag');
        $(".bootstrap-tagsinput").addClass('col-sm-12').find('input').addClass('form-control')
            .attr('placeholder', '输入后按enter');

        // 上传图片
        layui.use('upload', function(){
            var upload = layui.upload;

            //执行实例
            var uploadInst = upload.render({
                elem: '#test1' //绑定元素
                ,url: "<?php echo url('articles/uploadImg'); ?>" //上传接口
                ,done: function(res){
                    //上传完毕回调
                    $("#thumbnail").val(res.data.src);
                    $("#sm").html('<img src="' + res.data.src + '" style="width:40px;height: 40px;"/>');
                }
                ,error: function(){
                    //请求异常回调
                }
            });
        });

        var editor = UE.getEditor('container');
    });

    // 表单验证
    $.validator.setDefaults({
        highlight: function(e) {
            $(e).closest(".form-group").removeClass("has-success").addClass("has-error")
        },
        success: function(e) {
            e.closest(".form-group").removeClass("has-error").addClass("has-success")
        },
        errorElement: "span",
        errorPlacement: function(e, r) {
            e.appendTo(r.is(":radio") || r.is(":checkbox") ? r.parent().parent().parent() : r.parent())
        },
        errorClass: "help-block m-b-none",
        validClass: "help-block m-b-none"
    });

</script>
</body>
</html>
