<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:84:"E:\phpStudy\PHPTutorial\WWW\ceshi1\public/../application/admin\view\index\index.html";i:1529648804;}*/ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>后台管理</title>
        <link rel="shortcut icon" href="favicon.ico"> 
        <script src="__JS__/echarts.js"></script>
        <link rel="stylesheet" type="text/css" href="__STATIC__/admin/hui/static/h-ui/css/H-ui.min.css" />
        <link rel="stylesheet" type="text/css" href="__STATIC__/admin/hui/static/h-ui.admin/css/H-ui.admin.css" />
        <link rel="stylesheet" type="text/css" href="__STATIC__/admin/hui/lib/Hui-iconfont/1.0.8/iconfont.css" />
        <link rel="stylesheet" type="text/css" href="__STATIC__/admin/hui/static/h-ui.admin/skin/default/skin.css" id="skin" />
        <script src="https://lib.baomitu.com/echarts/4.0.3/echarts.min.js"></script>
    </head>
    <style type="text/css">
        #mainer{min-height:500px; text-align:center;width:100%; margin:0px auto 20px auto;height:auto; padding:0px 0; overflow:hidden; background-color:#fff;}
        #mainer{text-align:left;}
        *{box-sizing: border-box;}
        *::before, *::after{box-sizing: border-box;}
        *::before, *::after{box-sizing: border-box;}
        h3, .h3{font-size: 24px;}
        .m-t-xs{margin-top: 5px;}
        .block{display: block;}
        .scrollable{margin:10px;}
        .panel.panel-default{border-color: #e8e8e8;}
        .bg-light.lter, .bg-light .lter{background-color: #fefefe;}
        .m-t{margin-top: 15px;}
        .panel{border-radius: 2px;}
        .panel-default{border-color: #ddd;}
        .panel{background-color: #fff; border: 1px solid transparent; border-radius: 4px; box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05); margin-bottom: 20px; display: block; height:82px;}
        .b-light{border-color: #e4e4e4;}
        .b-r{border-right: 1px solid #cfcfcf;}
        .padder-v{padding-bottom: 15px; padding-top: 15px;}
        .col-md-3{width: 20%;height:80px;}
        .m-r-sm{margin-right: 10px;}
        .fa-stack{display: inline-block; height: 2em; line-height: 2em; position: relative; vertical-align: middle; width: 2em;}
        .fa-2x{font-size: 2em;}
        .pull-left{float: left !important;}
        small{font-size: 12px;}
        .text-primary{color: #65bd77;}
        .text-info{color: #4cc0c1;}
        .text-success{color: #8ec165;}
        .text-warning{color: #ffc333;}
        .text-danger{color: #fb6b5b;}
        .text-light{color: #f1f1f1;}
        .text-white{color: #fff;}
        .text-dark{color: #2e3e4e;}
        .text-blue{color: #368ee0;}
        .text-muted{color: #979797;}
        .text-center{text-align: center;}
        .fa-stack-2x{font-size: 2em;}
        .fa-stack-1x, .fa-stack-2x{left: 0; position: absolute; text-align: center; width: 100%;}
        .fa{display: inline-block; font-style: normal; font-weight: normal; line-height: 1;}
        .fa-stack-1x{line-height: inherit;}
        .panel.panel-default > .panel-heading, .panel.panel-default > .panel-footer{border-color: #e8e8e8;}
        .panel-default > .panel-heading{background-color: #f5f5f5; border-color: #ddd; color: #333;}
        .panel-heading{border-bottom: 1px solid transparent; border-top-left-radius: 3px; border-top-right-radius: 3px; padding: 10px 15px;}
        .panel-body::after, .modal-footer::before, .modal-footer::after, .row::after{content: " "; display: table;}
        .panel-body{padding: 15px;}
        .no-padder{padding: 0 !important;}
        .list-group-item{line-height:30px;}
    </style>

    <div id="mainer">
        <div class="scrollable padder">


            <section class="panel panel-default m-t">

                <div class="row m-l-none m-r-none bg-light lter">
                    <div class="col-sm-6 col-md-3 padder-v b-r b-light">
                        <span class="fa-stack fa-2x pull-left m-r-sm" style="text-align:right;">
                            <i class="Hui-iconfont">&#xe620;</i>
                        </span>
                        <a href="<?php echo url('pay/index'); ?>" class="clear">
                            <span class="h3 block m-t-xs"><strong><?php echo $return['order_total']; ?></strong></span>
                            <small class="text-muted text-uc">订单管理</small>
                        </a>
                    </div>

                    <div class="col-sm-6 col-md-3 padder-v b-r b-light lt">
                        <span class="fa-stack fa-2x pull-left m-r-sm" style="text-align:right;">
                            <i class="Hui-iconfont">&#xe66a;</i>
                            <span data-update="3000" data-target="#bugs" data-animate="2000" data-line-cap="butt" data-size="50" data-scale-color="false" data-track-color="#fff" data-line-width="4" data-percent="100" class="easypiechart pos-abt"></span>
                        </span>
                        <a href="<?php echo url('keepout/index'); ?>" class="clear">
                            <span class="h3 block m-t-xs"><strong id="bugs"><?php echo $return['keep_total']; ?></strong></span>
                            <small class="text-muted text-uc">存酒数</small>
                        </a>
                    </div>

                    <div class="col-sm-6 col-md-3 padder-v b-r b-light lt">
                        <span class="fa-stack fa-2x pull-left m-r-sm" style="text-align:right;">
                            <i class="Hui-iconfont">&#xe620;</i>
                            <span data-update="3000" data-target="#bugs" data-animate="2000" data-line-cap="butt" data-size="50" data-scale-color="false" data-track-color="#fff" data-line-width="4" data-percent="100" class="easypiechart pos-abt"></span>
                        </span>
                        <a href="<?php echo url('keepout/index'); ?>" class="clear">
                            <span class="h3 block m-t-xs"><strong id="Strong1"><?php echo $return['out_total']; ?></strong></span>
                            <small class="text-muted text-uc">取酒数</small>
                        </a>
                    </div>

                    <div class="col-sm-6 col-md-3 padder-v b-r b-light">
                        <span class="fa-stack fa-2x pull-left m-r-sm" style="text-align:right;">
                            <i class="Hui-iconfont">&#xe60d;</i>
                            <span data-update="5000" data-target="#firers" data-animate="3000" data-line-cap="butt" data-size="50" data-scale-color="false" data-track-color="#f5f5f5" data-line-width="4" data-percent="100" class="easypiechart pos-abt"></span>
                        </span>
                        <a href="<?php echo url('member/index'); ?>" class="clear">
                            <span class="h3 block m-t-xs"><strong id="firers"><?php echo $return['today_mem_total']; ?> / <?php echo $return['mem_total']; ?></strong></span>
                            <small class="text-muted text-uc">今日注册 / 登录会员</small>
                        </a>
                    </div>

                    <div class="col-sm-6 col-md-3 padder-v b-r b-light lt">
                        <span class="fa-stack fa-2x pull-left m-r-sm" style="text-align:right;">
                            <i class="Hui-iconfont">&#xe63a;</i>
                        </span>
                        <a href="<?php echo url('capital/recharge'); ?>" class="clear">
                            <span class="h3 block m-t-xs"><strong>￥<?php echo $return['recharge_today_total']; ?></strong></span>
                            <small class="text-muted text-uc">昨日充值金额</small>
                        </a>
                    </div>

                </div>
            </section>

            <div class="row" style="overflow: hidden">
                <div class="col-md-8" style="width:50%;">
                    <div class="panel panel-default" style="height: 390px;">
                        <header class="panel-heading font-bold">7天订单数据<small>（<?php echo $return['day7datetime']; ?>）</small></header>
                        <!--控制底部距离上面的距离-->
                        <div class="bg-light dk wrapper" style="height:285px;">
                            <div class="text-center m-b-n m-t-sm">
                                <div class="js_turnover" id="js_turnover"  style="width:100%;height: 300px">

                                </div>
                            </div>
                        </div>

                        <footer class="panel-footer bg-white no-padder">
                            <div class="row text-center no-gutter">

                                <div class="col-xs-3 b-r b-light">
                                    <span class="h4 font-bold m-t block"><?php echo $return['order_7_total']; ?> / 次</span>
                                    <small class="text-muted m-b block">订单总数</small>
                                </div>

                                <div class="col-xs-3 b-r b-light">
                                    <span class="h4 font-bold m-t block">￥<?php echo $return['order_7_momey_total']; ?></span>
                                    <small class="text-muted m-b block">7天交易额</small>
                                </div>

                            </div>
                        </footer>

                    </div>
                </div>

                <div class="col-md-8" style="width:50%;">
                    <div class="panel panel-default" style="height: 390px;">
                        <header class="panel-heading font-bold">本月充值数据<small> ( <?php echo $return['day30datetime']; ?> )</small></header>
                        <!--控制底部距离上面的距离-->
                        <div class="panel-body"  style="height: 285px;">
                            <div id="visit_charts">
                                <div class="load" id="box" style="width: 100%;height:300px;">

                                </div>
                            </div>
                        </div>

                        <footer class="panel-footer bg-white no-padder">
                            <div class="row text-center no-gutter">

                                <div class="col-xs-3 b-r b-light">
                                    <span class="h4 font-bold m-t block"> <?php echo $return['recharge_30_today_total']; ?> </span>
                                    <small class="text-muted m-b block">本月充值数</small>
                                </div>

                                <div class="col-xs-3 b-r b-light">
                                    <span class="h4 font-bold m-t block">￥ <?php echo $return['recharge_30_total']; ?> </span>
                                    <small class="text-muted m-b block">本月充值总额</small>
                                </div>



                            </div>
                        </footer>
                    </div>
                </div>
            </div>		
        </div>
    </div>
<script src="__JS__/jquery.min.js?v=2.1.4"></script>
<script src="__JS__/bootstrap.min.js?v=3.3.6"></script>
<script src="__JS__/content.min.js?v=1.0.0"></script>
<script src="__JS__/plugins/bootstrap-table/bootstrap-table.min.js"></script>
<script src="__JS__/plugins/bootstrap-table/bootstrap-table-mobile.min.js"></script>
<script src="__JS__/plugins/bootstrap-table/locale/bootstrap-table-zh-CN.min.js"></script>
<script src="__JS__/plugins/layer/laydate/laydate.js"></script>
<script src="__JS__/plugins/layer/layer.min.js"></script>
    <script>
        $.ajax({
            url: "<?php echo url('index/get_order_list'); ?>",
            type: "get",
            async: false,
            success: function(e) {
                console.log(e);
                var myChart = echarts.init(document.getElementById("js_turnover"));
                option = {
                    tooltip: {
                        trigger: 'axis'
                    },
                    legend: {
                        data: ['时间', '交易金额']
                    },
                    xAxis: {
                        name: '日期',
                        type: 'category',
                        data: e.date
                    },
                    yAxis: {
                        name: '交易金额',
                        type: 'value'
                    },
                    series: [{
                            name: '交易金额',
                            data: e.total_price,
                            type: 'line',
                        }]
                };
                myChart.setOption(option);

            }
        });

        $.ajax({
            url: "<?php echo url('index/get_recharge_list'); ?>",
            type: "get",
            async: false,
            success: function(e) {
                console.log(e);
                var myseChart = echarts.init(document.getElementById("box"));
                option = {
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {
                            type: 'cross',
                            label: {
                                backgroundColor: '#283b56'
                            }
                        }
                    },
                    legend: {
                        data: ['充值数量', '派对名称']
                    },
                    xAxis: [
                        {
                            name: '日期',
                            type: 'category',
                            boundaryGap: true,
                            data: e.date
                        },
                        {
                            type: 'category',
                            boundaryGap: true,
                            data: e.total_price,
                            axisLine: {
                                lineStyle: {
                                    color: 'none',
                                }
                            }
                        }
                    ],
                    yAxis: [
                        {
                            name: '充值数量',
                            type: 'value',
                            scale: true,
                            max: e.max,
                            min: 0,
                            boundaryGap: [0.2, 0.2]
                        }
                    ],
                    series: [
                        {
                            name: '充值数量',
                            xAxisIndex: 1,
                            type: 'bar',
                            data: e.total_price,
                        }
                    ]
                };
                myseChart.setOption(option);
            }
        });
    </script>
</body>
</html>
