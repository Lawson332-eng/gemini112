// app.js - 小程序主逻辑
App({
  onLaunch() {
    // 小程序启动时执行
    console.log('塔罗预言小程序启动');

    // 初始化本地存储
    this.initStorage();

    // 获取系统信息
    this.getSystemInfo();
  },

  onShow() {
    // 小程序显示时执行
    console.log('小程序显示');
  },

  onHide() {
    // 小程序隐藏时执行
    console.log('小程序隐藏');
  },

  /**
   * 初始化本地存储
   */
  initStorage() {
    try {
      // 检查是否已有历史记录
      const history = wx.getStorageSync('divination_history');
      if (!history) {
        wx.setStorageSync('divination_history', []);
        console.log('初始化历史记录存储');
      }

      // 检查每日一卡记录
      const dailyCard = wx.getStorageSync('daily_card');
      if (!dailyCard) {
        wx.setStorageSync('daily_card', {});
        console.log('初始化每日一卡存储');
      }
    } catch (e) {
      console.error('初始化存储失败:', e);
    }
  },

  /**
   * 获取系统信息
   */
  getSystemInfo() {
    wx.getSystemInfo({
      success: (res) => {
        this.globalData.systemInfo = res;
        console.log('系统信息:', res);
      },
      fail: (err) => {
        console.error('获取系统信息失败:', err);
      }
    });
  },

  // 全局数据
  globalData: {
    systemInfo: null,
    userInfo: null
  }
});
