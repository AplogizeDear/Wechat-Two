// pages/alcohol/detail.js
var ports = require('../../utils/ports.js');
Page({
  /**
   * 页面的初始数据
   */
  data: {
    windetail:{},
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
      var that = this;
      var id = options.id;
      var app = getApp();
      var cid = app.globalData.cid;
      wx.request({
        url: ports.wincarddetail,
        data:{cid:cid,mid:app.globalData.mid,id:id},
        method: 'post',
        header: { 'content-type': 'application/json' },
        success:function(res){
          console.log(res.data);
          that.setData({
             windetail:res.data.data[0],
          })
        }
      })
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
      wx.setNavigationBarTitle({
        title: '酒卡详情'
      });
  },

})