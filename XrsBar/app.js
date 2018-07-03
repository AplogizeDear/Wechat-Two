App({
  //全局变量
  globalData: {
    cid: 0,
    appid: 'wx9777d1571721be5b',
    secret: '9507104ae5296c36f3be637020eee26f',
    image:'',
    mid:1,
  },
  //当小程序初始化完成时，会触发 onLaunch（全局只触发一次）

  onLaunch: function () {
    var that = this;
    var user = wx.getStorageSync('user') || {};
    var userInfo = wx.getStorageSync('userInfo') || {};
    if ((!user.openid || (user.expires_in || Date.now()) < (Date.now() + 600)) && (!userInfo.nickName)) {
      wx.login({
        success: function (res) {
          if (res.code) {
            wx.getUserInfo({
              success: function (res) {
                var objz = {};
                objz.avatarUrl = res.userInfo.avatarUrl;
                objz.nickName = res.userInfo.nickName;
                //console.log(objz);  
                wx.setStorageSync('userInfo', objz);//存储userInfo  
              }
            });
            var d = that.globalData;//这里存储了appid、secret、token串    
            var l = 'https://api.weixin.qq.com/sns/jscode2session?appid=' + d.appid + '&secret=' + d.secret + '&js_code=' + res.code + '&grant_type=authorization_code';
            wx.request({
              url: l,
              data: {},
              method: 'GET', // OPTIONS, GET, HEAD, POST, PUT, DELETE, TRACE, CONNECT    
              // header: {}, // 设置请求的 header    
              success: function (res) {
                var obj = {};
                obj.openid = res.data.openid;
                obj.expires_in = Date.now() + res.data.expires_in;
                //console.log(obj);  
                wx.setStorageSync('user', obj);//存储openid    
              }
            });
          } else {
            console.log('获取用户登录态失败！' + res.errMsg)
          }
        }
      });
    }
  },  

  // 当小程序启动，或从后台进入前台显示，会触发 onShow

  onShow: function (options) {

  },

  //  当小程序从前台进入后台，会触发 onHide

  onHide: function () {

  },

  // 当小程序发生脚本错误，或者 api 调用失败时，会触发 onError 并带上错误信息

  onError: function (msg) {

  }
})
