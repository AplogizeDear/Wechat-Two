// pages/recharge/recharge.js
var ports = require('../../utils/ports.js');
Page({

  /**
   * 页面的初始数据
   */
  data: {
      "balance":'',
      "goodflowers": [],
      "gross":'0',
      'priceSelect':0,
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var money = options.money;

    var that=this;
    var app=getApp();
    var cid = app.globalData.cid;
    wx.request({
      url: ports.recharge,
      method:'post',
      header: { 'content-type': 'application/json' },
      data:{cid:cid , mid:app.globalData.mid},
      success:function(res){
        that.setData({
          balance:money,
          goodflowers:res.data.data.recharge
        })
      }
    })
      wx.setNavigationBarTitle({
        title: '充值',
      });
  },
  // 切换优惠价格
  chooseprice: function (data) {
    var that = this;
    var price_id = data.currentTarget.dataset.select;
    //把选中值，放入判断值中,根据判断值进行选中
    that.setData({
      priceSelect: price_id
    })
    //余额
    var databanlance = parseFloat(that.data.balance);
    // 获取当前选中值
    var cuprice = parseFloat(data.currentTarget.dataset.pricename);
    // 获取折扣
    var desc = parseFloat(data.currentTarget.dataset.desc);
    // 总价格
    var gross = databanlance + desc + cuprice;
    this.setData({
      'gross': cuprice,
    })
  },
  getConsumerDetail:function(){
      wx.navigateTo({
        url: '../consumer/detail',
      })
  }

})