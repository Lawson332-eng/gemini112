// pages/index/index.js
const { getDailyCard, saveDailyCard, formatDate } = require('../../utils/storage.js');
const { generateDailyCard } = require('../../utils/card-shuffle.js');

Page({
  /**
   * 页面的初始数据
   */
  data: {
    dailyCard: null, // 每日一卡数据
    isLoading: true
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad(options) {
    this.loadDailyCard();
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow() {
    // 每次显示时检查每日一卡是否需要更新
    this.checkAndUpdateDailyCard();
  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh() {
    this.refreshDailyCard();
  },

  /**
   * 加载每日一卡
   */
  loadDailyCard() {
    wx.showLoading({
      title: '加载中...',
      mask: true
    });

    try {
      // 尝试从缓存获取每日一卡
      const cached = getDailyCard();

      if (cached && cached.card) {
        // 如果有今日的卡牌,直接使用
        this.setData({
          dailyCard: cached.card,
          isLoading: false
        });
      } else {
        // 如果没有,生成新的每日一卡
        this.generateNewDailyCard();
      }
    } catch (e) {
      console.error('加载每日一卡失败:', e);
      wx.showToast({
        title: '加载失败',
        icon: 'none'
      });
    } finally {
      wx.hideLoading();
    }
  },

  /**
   * 生成新的每日一卡
   */
  generateNewDailyCard() {
    const today = formatDate(new Date(), 'YYYY-MM-DD');
    const card = generateDailyCard(today);

    // 保存到缓存
    saveDailyCard(card);

    this.setData({
      dailyCard: card,
      isLoading: false
    });

    // 显示抽卡成功提示
    wx.showToast({
      title: '已为您抽取今日塔罗',
      icon: 'success',
      duration: 1500
    });
  },

  /**
   * 检查并更新每日一卡
   */
  checkAndUpdateDailyCard() {
    const cached = getDailyCard();
    const today = formatDate(new Date(), 'YYYY-MM-DD');

    // 如果缓存的卡牌不是今天的,重新生成
    if (!cached || cached.date !== today) {
      this.generateNewDailyCard();
    }
  },

  /**
   * 刷新每日一卡（下拉刷新触发）
   */
  refreshDailyCard() {
    this.generateNewDailyCard();

    // 停止下拉刷新动画
    setTimeout(() => {
      wx.stopPullDownRefresh();
    }, 1000);
  },

  /**
   * 查看每日一卡详情
   */
  viewDailyCard() {
    if (!this.data.dailyCard) {
      wx.showToast({
        title: '正在加载中...',
        icon: 'none'
      });
      return;
    }

    // 震动反馈
    wx.vibrateShort({
      type: 'light'
    });

    // 跳转到牌面详情页
    wx.navigateTo({
      url: `/pages/card-detail/card-detail?cardId=${this.data.dailyCard.id}&isReversed=${this.data.dailyCard.isReversed}`
    });
  },

  /**
   * 前往单牌占卜页面
   */
  goToSingleCard() {
    wx.vibrateShort({
      type: 'light'
    });

    wx.navigateTo({
      url: '/pages/single-card/single-card'
    });
  },

  /**
   * 前往三牌阵占卜页面
   */
  goToThreeCards() {
    wx.vibrateShort({
      type: 'light'
    });

    wx.navigateTo({
      url: '/pages/three-cards/three-cards'
    });
  },

  /**
   * 前往牌库页面
   */
  goToCardLibrary() {
    wx.vibrateShort({
      type: 'light'
    });

    wx.switchTab({
      url: '/pages/card-library/card-library'
    });
  },

  /**
   * 前往历史记录页面
   */
  goToHistory() {
    wx.vibrateShort({
      type: 'light'
    });

    wx.switchTab({
      url: '/pages/history/history'
    });
  }
});
