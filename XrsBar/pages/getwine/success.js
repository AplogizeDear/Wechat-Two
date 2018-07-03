// pages/getwine/success.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
  
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
  
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
      wx.setNavigationBarTitle({
        title: '取酒成功'
      });
  },

  goBackIndex:function(){
      wx.redirectTo({
        url: '../index/index',
      })
  }
  
})