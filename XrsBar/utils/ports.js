/* 测试接口api */
var wdomain = "https://jbxcx.linxsl.top";

module.exports = {
  // 登录模块 login

  //首页请求api
  index:wdomain,
  // 充值  请求接口api
  recharge:wdomain+'/index/index/recharge',
  // 会员卡信息
  
  // 消费明细
  rechargeinfo: wdomain +'/index/index/rechargeinfo',
  //取酒
  getwine: wdomain+'/index/index/out',
  //积分列表
  point: wdomain +'/index/index/point_list',
  // 酒卡
  wincard: wdomain + '/index/index/stock',
  // 酒卡详情信息
  wincarddetail: wdomain + '/index/index/stock_info',
  // 红人榜消费总额s
  redpople: wdomain + '/index/index/consume_list',
  //红人榜单桌消费
  onlyred: wdomain + '/index/index/consume_seat_list',
  // 取酒记录
  getwinehistory: wdomain + '/index/index/out_list',
  // 取酒数据发送
  updata: wdomain + '/index/index/outover',
  //取酒二维码
  getwineewm:wdomain + '/index/index/keep'
}