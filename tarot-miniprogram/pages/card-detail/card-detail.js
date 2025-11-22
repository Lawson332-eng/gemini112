// pages/card-detail/card-detail.js
const { TAROT_CARDS } = require('../../data/tarot-cards.js');
const { getCardMeaning } = require('../../data/card-meanings.js');

Page({
  data: {
    card: null,
    uprightMeaning: null,
    reversedMeaning: null,
    isReversed: false
  },

  onLoad(options) {
    const cardId = parseInt(options.cardId);
    const isReversed = options.isReversed === 'true';

    const card = TAROT_CARDS.find(c => c.id === cardId);

    if (card) {
      const uprightMeaning = getCardMeaning(cardId, false);
      const reversedMeaning = getCardMeaning(cardId, true);

      this.setData({
        card,
        uprightMeaning,
        reversedMeaning,
        isReversed
      });
    } else {
      wx.showToast({
        title: '卡牌不存在',
        icon: 'none'
      });
      setTimeout(() => {
        wx.navigateBack();
      }, 1500);
    }
  }
});
