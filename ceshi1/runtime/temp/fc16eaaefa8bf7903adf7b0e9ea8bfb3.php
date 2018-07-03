<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:85:"E:\phpStudy\PHPTutorial\WWW\ceshi1\public/../application/admin\view\set\recharge.html";i:1529388907;}*/ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>充值设置</title>
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
                            <h5>充值设置</h5>
                        </div>
                        <div class="ibox-content">
                            <form class="form-horizontal m-t" id="commentForm" method="post" action="<?php echo url('set/recharge'); ?>">
                                <div class="form-group" id="recharge">
                                    <?php if($info ==''): ?>
                                    <div class="input-group col-sm-7 recharge_s" style="width: 100%" >
                                        <label class="col-sm-3 control-label" style="width:12%">充值</label>
                                        <input id="recharge_1" type="text" class="form-control" name="recharge_1" required="" aria-required="true" value="" style="width:100px" onkeyup="this.value = this.value.replace(/[^0-9-]+/, '');">
                                        <label class="col-sm-3 control-label" style="width:13%">元，送</label>
                                        <input id="recharges_1" type="text" class="form-control" name="recharges_1" required="" aria-required="true" value="" style="width:100px" onkeyup="this.value = this.value.replace(/[^0-9-]+/, '');">
                                        <label class="col-sm-3 control-label" style="width:3%">元</label>
                                        <span class="btn btn-primary" style="margin-left: 50px;"><i class="fa fa-plus-square" onclick="add()"></i></span>
                                    </div>
                                    <?php else: if(is_array($info) || $info instanceof \think\Collection || $info instanceof \think\Paginator): $k = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>
                                    <div class="input-group col-sm-7 recharge_s" style="width: 100%" >
                                        <label class="col-sm-3 control-label" style="width:12%">充值</label>
                                        <input id="recharge_<?php echo $k; ?>" type="text" class="form-control" name="recharge_<?php echo $k; ?>" required="" aria-required="true" value="<?php echo $vo['0']; ?>" style="width:100px" onkeyup="this.value = this.value.replace(/[^0-9-]+/, '');">
                                        <label class="col-sm-3 control-label" style="width:13%">元，送</label>
                                        <input id="recharges_<?php echo $k; ?>" type="text" class="form-control" name="recharges_<?php echo $k; ?>" required="" aria-required="true" value="<?php echo $vo['1']; ?>" style="width:100px" onkeyup="this.value = this.value.replace(/[^0-9-]+/, '');">
                                        <label class="col-sm-3 control-label" style="width:3%">元</label>
                                        <?php switch($k): case "1": ?>
                                        <span class="btn btn-primary" style="margin-left: 50px;"><i class="fa fa-plus-square" onclick="add()"></i></span>
                                        <?php break; default: ?>
                                        <span class="btn btn-primary" style="margin-left: 50px;" id="delete"><i class="fa fa-times-circle" onclick="delete_recharge(this)" name="<?php echo $k; ?>"></i></span>
                                        <?php endswitch; ?>
                                    </div>
                                    <?php endforeach; endif; else: echo "" ;endif; endif; ?>
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
        <div style="display: none" id="hidden">
            <div class="input-group col-sm-7 recharge_s" style="width: 100%" >
                <label class="col-sm-3 control-label" style="width:12%">充值</label>
                <input id="recharge" type="text" class="form-control" name="recharge" required="" aria-required="true" value="" style="width:100px" onkeyup="this.value = this.value.replace(/[^0-9-]+/, '');">
                <label class="col-sm-3 control-label" style="width:13%">元，送</label>
                <input id="recharges" type="text" class="form-control" name="recharges" required="" aria-required="true" value="" style="width:100px" onkeyup="this.value = this.value.replace(/[^0-9-]+/, '');">
                <label class="col-sm-3 control-label" style="width:3%">元</label>
                <span class="btn btn-primary" style="margin-left: 50px;" id="delete"><i class="fa fa-times-circle" onclick="delete_recharge(this)"></i></span>
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
                    function showStart() {
                        index = layer.load(0, {shade: false});
                        return true;
                    }

                    function showSuccess(res) {

                        layer.ready(function() {
                            layer.close(index);
                            if (1 == res.code) {
                                layer.alert(res.msg, {title: '友情提示', icon: 1, closeBtn: 0}, function() {
                                    window.location.href = res.data;
                                });
                            } else if (111 == res.code) {
                                window.location.reload();
                            } else {
                                layer.msg(res.msg, {anim: 6});
                            }
                        });
                    }

                    $(document).ready(function() {
                        // 添加角色
                        var options = {
                            beforeSubmit: showStart,
                            success: showSuccess
                        };

                        $('#commentForm').submit(function() {
                            $(this).ajaxSubmit(options);
                            return false;
                        });

                        $('#keywords').tagsinput('add', 'some tag');
                        $(".bootstrap-tagsinput").addClass('col-sm-12').find('input').addClass('form-control')
                                .attr('placeholder', '输入后按enter');

                        // 上传图片
                        layui.use('upload', function() {
                            var upload = layui.upload;

                            //执行实例
                            var uploadInst = upload.render({
                                elem: '#test1' //绑定元素
                                , url: "<?php echo url('activity/uploadImg'); ?>" //上传接口
                                , done: function(res) {
                                    //上传完毕回调
                                    $("#banner").val(res.data.src);
                                    $("#sm").html('<img src="' + res.data.src + '" style="width:40px;height: 40px;"/>');
                                }
                                , error: function() {
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
                    function add() {
                        var id = $('#recharge .recharge_s:last input:first').attr('id');
                        var a = id.split('_');
                        var length = a[1];
                        $("#hidden .recharge_s").clone().insertAfter($("#recharge .recharge_s:last"));
                        var len = Number(length) + 1;
                        var recharge = 'recharge' + '_' + len;
                        var recharge_s = 'recharges' + '_' + len;
                        $('#recharge .recharge_s:last #recharge').attr('name', recharge);
                        $('#recharge .recharge_s:last #recharges').attr('name', recharge_s);
                        $('#recharge .recharge_s:last #recharge').attr('id', recharge);
                        $('#recharge .recharge_s:last #recharges').attr('id', recharge_s);
                        $('#recharge .recharge_s:last #delete i').attr('name', len);
                    }
                    function delete_recharge(obj) {
                        var a = $(obj).attr('name');
                        $("#recharge_" + a).parent().remove();
                    }
        </script>
    </body>
</html>
