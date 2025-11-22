// pages/card-library/card-library.js
const { TAROT_CARDS } = require('../../data/tarot-cards.js');

Page({
  data: {
    allCards: TAROT_CARDS,
    filteredCards: TAROT_CARDS,
    activeFilter: 'all'
  },

  onLoad() {
    // 页面加载时显示所有卡牌
  },

  // 筛选卡牌
  filterCards(e) {
    const type = e.currentTarget.dataset.type;
    let filtered = [];

    if (type === 'all') {
      filtered = this.data.allCards;
    } else if (type === 'major') {
      filtered = this.data.allCards.filter(card => card.type === 'major');
    } else if (type === 'minor') {
      filtered = this.data.allCards.filter(card => card.type === 'minor');
    }

    this.setData({
      filteredCards: filtered,
      activeFilter: type
    });
  },

  // 查看卡牌详情
  viewCardDetail(e) {
    const cardId = e.currentTarget.dataset.id;
    wx.vibrateShort({ type: 'light' });
    wx.navigateTo({
      url: `/pages/card-detail/card-detail?cardId=${cardId}`
    });
  }
});
