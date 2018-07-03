// pages/takelog/takelog.js
var ports = require('../../utils/ports.js');
Page({

  /**
   * 页面的初始数据
   */
  data: {
    alldata:[],
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that=this;
    var app = getApp();
    var cid = app.globalData.cid;
    console.log(cid);
      wx.request({
        url: ports.getwinehistory,
        method:'post',
        header: { 'content-type': 'application/json' },
        data:{cid:cid,mid:app.globalData.mid},
        success:function(res){
          that.setData({
            alldata:res.data.data.info,
          })
        }
      })
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
      wx.setNavigationBarTitle({
        title: '取酒记录'
      });
  }
})