// pages/points/points.js
var ports = require('../../utils/ports.js');
Page({

  /**
   * 页面的初始数据
   */
  data: {
    point:[],
    ponit_info:[],
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var app = getApp();
    var that = this;
      wx.request({
        url: ports.point,
        method:'post',
        data:{cid:app.globalData.cid,mid:app.globalData.mid},
        header: {'content-type': 'application/json'},
        success:function(res){
          console.log(res.data);
          that.setData({
             point:res.data.data.point,
             point_info:res.data.data.point_info,
          })
        }
      })
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
    wx.setNavigationBarTitle({
        title: '我的积分'
    });
  },

  getPointsRule:function(){
    wx.navigateTo({
      url: '../points/points-rule',
    })
  }
})