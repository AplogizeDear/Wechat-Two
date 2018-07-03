// pages/consumer/detail.js
var ports = require('../../utils/ports.js');
Page({

  /**
   * 页面的初始数据
   */
  data: {
    recharge_info:[]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
      var that = this;
      var app = getApp();
      var cid = app.globalData.cid;
      console.log(cid);
      wx.request({
        url: ports.rechargeinfo,
        method:'post',
        header: { 'content-type': 'application/json' },
        // 记得先将用户信息传递回去
        data:{cid:cid,mid:app.globalData.mid},
        success:function(res){
          console.log(res.data);
          that.setData({
            recharge_info: res.data.data.recharge_info
          })
        }
      })
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
      wx.setNavigationBarTitle({
        title: '消费明细'
      });
  },

})