// pages/vipcard/vipcard.js
var WxParse = require('../../wxParse/wxParse.js');
Page({

  /**
   * 页面的初始数据
   */
  data: {
    card:[],
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var app = getApp();
    var that =this;
    var id = options.id;
    wx.request({
      url: 'https://jbxcx.linxsl.top/index/index/card',
      method:'post',
      data:{cid:app.globalData.cid,mid:app.globalData.mid,id:id},
      header: {
        'content-type': 'application/json'
      },
      success: function (res) {
        console.log(res.data);
        var explain = res.data.data.explain;
        var explaint = res.data.data.explaint;
        var explainu = res.data.data.explainu;
        WxParse.wxParse('explain', 'html', explain, that, 5);
        WxParse.wxParse('explaint', 'html', explaint, that, 5);
        WxParse.wxParse('explainu', 'html', explainu, that, 5);
        that.setData({
            card:res.data.data
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
        title: '会员卡详情'
      });
  },
  getwine:function(){
    wx.navigateTo({
      url: '../../pages/getwine/getwine',
    })
  }
})