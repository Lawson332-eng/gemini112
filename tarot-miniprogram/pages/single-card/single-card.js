// pages/single-card/single-card.js
const { drawSingleCard } = require('../../utils/card-shuffle.js');
const { getCardMeaning } = require('../../data/card-meanings.js');
const { saveDivinationRecord } = require('../../utils/storage.js');

Page({
  data: {
    card: null,
    meaning: null
  },

  // 抽牌
  drawCard() {
    wx.vibrateShort({ type: 'medium' });

    const card = drawSingleCard(true);
    const meaning = getCardMeaning(card.id, card.isReversed);

    this.setData({ card, meaning });

    wx.showToast({
      title: '抽牌成功',
      icon: 'success'
    });
  },

  // 重新抽牌
  reset() {
    this.setData({
      card: null,
      meaning: null
    });
  },

  // 保存记录
  saveRecord() {
    const record = {
      type: 'single',
      cards: [this.data.card],
      meaning: this.data.meaning
    };

    const success = saveDivinationRecord(record);

    wx.showToast({
      title: success ? '保存成功' : '保存失败',
      icon: success ? 'success' : 'none'
    });
  }
});
