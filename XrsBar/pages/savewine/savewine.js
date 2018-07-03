// pages/savewine/savewine.js
var ports = require('../../utils/ports.js');
Page({

  /**
   * 页面的初始数据
   */
  data: {
    logo:'',
    cname:'',
    url:'',
  },

  /**
   * 生命周期函数--监听页面加载
   */

  onLoad: function (options) {
    var that = this;
    var app = getApp();
    var cid = app.globalData.cid;
    wx.request({
      url: ports.getwineewm,
      method: 'post',
      header: { 'content-type': 'application/json' },
      data: { cid: cid ,mid:app.globalData.mid},
      success: function (res) {
          that.setData({
              logo:res.data.data.logo,
              cname:res.data.data.cname,
              url:res.data.data.url
          })
      },
      fail: function (err) {
        console.log(err);
      }
    })
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
      wx.setNavigationBarTitle({
        title: '存酒'
      });
  }
  
})