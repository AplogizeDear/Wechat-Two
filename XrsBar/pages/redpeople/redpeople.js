// pages/redpeople/redpeople.js
var ports = require('../../utils/ports.js');
Page({

  /**
   * 页面的初始数据
   */
  data: {
    // 总的消费额
    infot:[],
    infos:[],
    info:[],
    // 单桌消费额
    // 总排名
    Totalrank:[],
    //用户个人排名
    perrank:[],
    // 前三
    topthree:[],
    'currentTabsIndex': 0,
    'selected': 0,
     menu:[],
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that=this;
    var app = getApp();
    var cid = app.globalData.cid;
      wx.request({
        url: ports.redpople,
        method:'post',
        header: { 'content-type': 'application/json' },
        data: { cid: cid, mid: app.globalData.mid},
        success:function(res){
          that.setData({
            infot: res.data.data.infot,
            infos: res.data.data.infos,
            info: res.data.data.info
          })
        }
      })
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
      wx.setNavigationBarTitle({
        title: '红人榜'
      });
  },
  turnMenu:function(data){
    var that =this;
    var app = getApp();
    var cid = app.globalData.cid;
    var id = data.currentTarget.dataset.id;
    console.log(cid);
    console.log(id);
    wx.request({
      url: ports.onlyred,
      data: { cid: cid, mid: app.globalData.mid,sid:id},
      method: 'post',
      header: { 'content-type': 'application/json' },
      success:function(res){
        console.log(res.data);
          that.setData({
              menu:res.data.data,
              Totalrank:res.data.data.info,
              topthree:res.data.data.infot,
              perrank:res.data.data.infos
          })
      }
    })
    this.setData({
      selected: data.currentTarget.dataset.index
    })
  },
  onTabsItemTap: function (event){
    var that=this;
    var index = event.target.dataset.index;
    var app = getApp();
    var cid = app.globalData.cid;
    if(index==1){
      wx.request({
        url: ports.onlyred,
        method: 'post',
        header: { 'content-type': 'application/json' },
        data: { cid: cid, mid:app.globalData.mid},
        success:function(res){
          console.log(res.data);
            that.setData({
               menu:res.data.data,
            })
        }
      })
    }
    this.setData({
        currentTabsIndex: index
    })
  }
  
})