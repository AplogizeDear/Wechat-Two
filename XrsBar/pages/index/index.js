var ports = require('../../utils/ports.js');
Page({
  data: {
    open: false,
    lastX: 0,
    lastY: 0,
    text: "没有滑动",
    activity:[],
    card:[],
    member:[],
  },
  // 首页数据加载
  onLoad: function (options) {
    //OpenId
    var app = getApp();
    var that = this;
    var app= getApp();
    wx.request({
      url: ports.index,
      method: 'post',
      header: { 'content-type': 'application/json' },
      data: 
      { 'cid': app.globalData.cid, 'mid': app.globalData.mid},
      success: function (res) {
        that.setData({
          activity: res.data.data.activity,
          card:res.data.data.card,
          member:res.data.data.member
        })
        wx.setStorageSync('card', res.data.card);
      },
      fail: function (err) {
        console.log(err)
      }
    }) 
    wx.getSetting({
      success: function (res) {
        
      }
    }),
    wx.login({

    });
  }, 
  tap_ch: function (e) {
    if (this.data.open) {
      this.setData({
        open: false
      });
    } else {
      this.setData({
        open: true
      });
    }
  },

  onGotUserInfo: function (e) {
    // 返回的是用户信息
    console.log(e.detail.userInfo)
    this.setData({
      username: e.detail.userInfo.nickName,
      avatarUrl: e.detail.userInfo.avatarUrl
    })
  },

  getPhoneNumber: function (e) {
    console.log(e.detail.errMsg)
    console.log(e.detail.iv)
    console.log(e.detail.encryptedData)
  },

  handletouchmove: function (event) {
    let currentX = event.touches[0].pageX;
    let currentY = event.touches[0].pageY;
    console.log(currentX - this.data.lastX);
    let text = ""
    if ((currentX - this.data.lastX) < -30){
      this.setData({
        open: false
      });
    }else if (((currentX - this.data.lastX) > 30)){
      this.setData({
        open: true
      });
    }
    //将当前坐标进行保存以进行下一次计算
    this.data.lastX = currentX
    this.data.lastY = currentY
    this.setData({
      text: text,
    });
  },

  handletouchtart: function (event) {
    this.data.lastX = event.touches[0].pageX
    this.data.lastY = event.touches[0].pageY
  },
  handletouchend: function (event) {
    console.log(event)
    this.data.currentGesture = 0
    this.setData({
      text: "没有滑动",
    });
  },
innerpage:function(){
  wx.navigateTo({
    url: '../innerpage/innerpage',
  })
},
  getVipCard: function (e) {
    wx.navigateTo({
      url: `../vipcard/vipcard?id=${e.currentTarget.dataset.id}`,
    })
  },

  getPoints:function(){
    wx.navigateTo({
      url: '../points/points',
    })
  },
  
  getTakeLog:function(){
      wx.navigateTo({
        url: '../takelog/takelog',
      })
  },

  getRedPeople:function(){
      wx.navigateTo({
        url: '../redpeople/redpeople',
      })
  },

  getAlcoholCard:function(){
      wx.navigateTo({
        url: '../winecard/card',
      })
  },

  getWine:function(){
    wx.navigateTo({
      url: '../getwine/getwine',
    })
  },

  getRecharge:function(){
    var money = this.data.member.money;
    console.log(money);
    wx.navigateTo({
      url: '../recharge/recharge?money='+money,
    })
  },

  saveWine:function(){
    wx.navigateTo({
      url: '../savewine/savewine',
    })
  }

})