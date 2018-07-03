// pages/getwine/getwine.js
// 引入接口
var ports = require('../../utils/ports.js');
Page({

  /**
   * 页面的初始数据
   */
  data: {
    "const":'0',
    'select_all': false,
    'selected':0,
    'allwine':[],
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this;
    var app = getApp();
    var cid = app.globalData.cid;
      wx.request({
        url: ports.getwine,
        data:{'cid':cid,mid:app.globalData.mid},
        method:'post',
        header: { 'content-type': 'application/json'},
        success:function(res){
            that.setData({
                allwine:res.data.data
            })
        }

      })
  },
  // 加
  bindPlus: function (e) {
    var info = this.data.allwine;
    var index =e.currentTarget.dataset.index;
    var hello = e.currentTarget.dataset.hello;
    var first_num = info[index].wintype[hello].first_num++;
    // 装数字  用来计算总和
    var arr2 = [];
    // 转换数组
    var arr = [];
    for (let i in info)
    { arr.push(info[i]);}
     if (info[index].wintype[hello].num){
        if (info[index].wintype[hello].first_num > info[index].wintype[hello].num){
          wx.showToast({
            title: '抱歉，存酒不足',
            icon: 'none',
            duration: 2000
          })
          info[index].wintype[hello].first_num = info[index].wintype[hello].first_num;
          return false;
        }
    }else{
       if (info[index].wintype[hello].first_num > 1) {
         info[index].wintype[hello].first_num = 1;
         wx.showToast({
           title: '抱歉，存酒不足',
           icon: 'none',
           duration: 2000
         })
         return false;
       }
    }
    for(let i=0;i<arr.length;i++){
      for (let k = 0; k < arr[i].wintype.length;k++){
        arr2.push(arr[i].wintype[k].first_num);
      }
    }
    var sum = 0;
    for (let i = 0; i < arr2.length; i++) {
      sum += arr2[i];
    }
    this.setData({
      const: sum,
      allwine: info,
    })
  }, 
// 减
  bindMinus: function (e) {
    var info = this.data.allwine;
    var index = e.currentTarget.dataset.index;
    var hello = e.currentTarget.dataset.hello;
    var first_num = info[index].wintype[hello].first_num--;
    info[index].checked=false;
    // 装数字  用来计算总和
    var arr2 = [];
    // 转换数组
    var arr = [];
    var arr6=[];
    for (let i in info)
    { arr.push(info[i]); }
    if (info[index].wintype[hello].first_num < 0) {
      wx.showToast({
        title: '抱歉,人家受不了了',
        icon: 'none',
        duration: 2000
      })
      info[index].wintype[hello].first_num = 0;
      return false;
    }
    for (let i = 0; i < arr.length; i++) {
      arr6.push(arr[i].checked);
      for (let k = 0; k < arr[i].wintype.length; k++) {
        arr2.push(arr[i].wintype[k].first_num);
      }
    }
    function isture(element) {
      return element == true;
    }
    var end = arr6.every(isture);
    if (end == true) {
      this.setData({
        select_all: true
      })
    } else {
      this.setData({
        select_all: false
      })
    }
    var sum = 0;
    for (let i = 0; i < arr2.length; i++) {
      sum += arr2[i];
    }
    this.setData({
      const: sum,
      allwine: info,
    }),
    // 将数值与状态写回
    this.setData({
      const: sum,
      allwine: info,
    });
  },
  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
      wx.setNavigationBarTitle({
        title: '取酒'
      });
  },
  // 选择
  select: function (e) {
    var that = this;
    let arr2 = [];
    let arr3 = [];
    let arr4=  [];
    var arr = that.data.allwine;
    var index = e.currentTarget.dataset.index;
    arr[index].checked = !arr[index].checked;
    // 取消全选全部还原为0
    if(arr[index].checked==false){
       for(let k=0;k<arr[index].wintype.length;k++){
         arr[index].wintype[k].first_num=0;
       }
    }
    var arr6 = [];
    for (let i in arr)
    {arr6.push(arr[i]);} 
    // 选中之后
    for (let i = 0; i < arr6.length; i++) {
      if (arr6[i].checked==true) {
        arr2.push(arr6[i]);
      }
    };
    for(let k=0;k<arr2.length;k++){
      for (let j = 0; j < arr2[k].wintype.length;j++){
        if (arr2[k].wintype[j].num){
          arr2[k].wintype[j].first_num = arr2[k].wintype[j].num;
        }else{
          arr2[k].wintype[j].first_num = 1;
        }
        arr3.push(arr2[k].wintype[j].first_num);
      }
    }
    // 如果全部选中
    var arrc = [];
    for (let i = 0; i < arr6.length; i++) {
      arrc.push(arr6[i].checked);
    }
   function isture(element){
     return element==true;
   }
   var end = arrc.every(isture);
   if(end==true){
     that.setData({
       select_all:true
     })
   }else{
     that.setData({
       select_all: false
     })
   }
    var sum = 0;
    for (var i = 0, sum = 0; i < arr3.length; i++) {
      sum += arr3[i];
    }
    that.setData({
      allwine: arr,
      const: sum,
    })
    
  },
  // 全选
  select_all: function () {
    let that = this;
    that.setData({
      select_all: true
    })
    if (that.data.select_all==true) {
      var arr6 = [];
      let arr = that.data.allwine;
      for (let i in arr)
      { arr6.push(arr[i]); } 
      let arr2 = [];
      for (let i = 0; i < arr6.length; i++) {
        if (arr6[i].checked == true) {
          arr2.push(arr6[i]);
        } else {
          arr6[i].checked = true;
          arr2.push(arr6[i]);
        }
      }
      var arr3=[];
      for (let k = 0; k < arr2.length; k++) {
        for (let j = 0; j < arr2[k].wintype.length; j++) {
          if(arr2[k].wintype[j].num){
            arr2[k].wintype[j].first_num = arr2[k].wintype[j].num;
          }else{
            arr2[k].wintype[j].first_num = 1;
          }
          arr3.push(arr2[k].wintype[j].first_num);
        }
      }
      var sum = 0;
      for (var i = 0, sum = 0; i < arr3.length; i++) {
        sum += arr3[i];
      }
      that.setData({
        allwine: arr2,
        const:sum
      })
    }
  },
  // 取消全选
  select_none:function(){
    let that = this;
    that.setData({
      select_all: false
    })
    let arr = that.data.allwine;
    let arr2 = [];
    for (let i = 0; i < arr.length; i++) {
        arr[i].checked = false;
        for (let k = 0; k < arr[i].wintype.length; k++) {
          arr[i].wintype[k].first_num=0;
        }
    }
    that.setData({
      const:0,
      allwine:arr
    })
  },
  getWineSuccess:function(){
    var app = getApp();
    if (this.data.const==0){
      wx.showToast({
        title: '请选择你要取出的酒',
        icon: 'none',
        duration: 2000
      })
      return false;
    }
    var arr1 =this.data.allwine;
    // 一个数组里面包含数组和对象
    var alldata = this.data.const; 
    wx.request({
      url:ports.updata,
      data:{data:arr1,cid:app.globalData.cid,mid:app.globalData.mid,alldata:alldata},
      method:'post',
      header: { 'content-type': 'application/json' },
      success:function(res){
        console.log(res.data);
        var url = res.data.data.url;
        var cname = res.data.data.cname;
        var logo = res.data.data.logo;
        wx.navigateTo({
          url: '../saveewm/saveewm?url='+url+'&cname='+cname+'&logo='+logo,
        })
      }
    })
  }
})