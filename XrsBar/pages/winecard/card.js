// pages/alcohol/card.js
var ports = require('../../utils/ports.js');
Page({

  /**
   * 页面的初始数据
   */
  data:{
    wincard:[]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this;
    var app = getApp();
    var cid = app.globalData.cid;
      wx.request({
        url: ports.wincard,
        data:{cid:cid,mid:app.globalData.mid},
        method:'post',
        header: { 'content-type': 'application/json' },
        success:function(res){
          that.setData({
              wincard:res.data.data,
          })
        }
      })
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
      wx.setNavigationBarTitle({
        title: '酒卡'
      });
  },

  getCardDetail:function(e){
    var id = e.currentTarget.dataset.id;
     wx.navigateTo({
       url: '../winecard/detail?id='+id,
     })
  },

  getWine:function(){
    wx.navigateTo({
      url: '../getwine/getwine',
    })
  }

})