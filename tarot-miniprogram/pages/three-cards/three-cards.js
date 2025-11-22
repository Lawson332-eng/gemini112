// pages/three-cards/three-cards.js
const { drawSingleCard } = require('../../utils/card-shuffle.js');
const { getCardMeaning } = require('../../data/card-meanings.js');
const { saveDivinationRecord } = require('../../utils/storage.js');

Page({
  data: {
    step: 0, // 0: 过去, 1: 现在, 2: 未来, 3: 完成
    drawnCards: [],
    stepHints: [
      '抽取第一张牌 - 过去',
      '抽取第二张牌 - 现在',
      '抽取第三张牌 - 未来'
    ],
    positionIcons: ['⏳', '⭐', '🌟'],
    overallMeaning: ''
  },

  // 抽取下一张牌
  drawNextCard() {
    wx.vibrateShort({ type: 'medium' });

    const card = drawSingleCard(true);
    const positions = ['past', 'present', 'future'];
    const positionNames = ['过去', '现在', '未来'];

    const positionedCard = {
      ...card,
      position: positions[this.data.step],
      positionName: positionNames[this.data.step]
    };

    const newCards = [...this.data.drawnCards, positionedCard];
    const newStep = this.data.step + 1;

    this.setData({
      drawnCards: newCards,
      step: newStep
    });

    // 如果已经抽完三张牌,生成综合解读
    if (newStep === 3) {
      this.generateOverallMeaning(newCards);
    }
  },

  // 生成综合解读
  generateOverallMeaning(cards) {
    const pastCard = cards[0];
    const presentCard = cards[1];
    const futureCard = cards[2];

    const overall = `过去的"${pastCard.name}"显示了你的起点,现在的"${presentCard.name}"揭示了当下的状态,而未来的"${futureCard.name}"则预示着即将到来的发展。这三张牌共同描绘出你生命的轨迹,建议你珍惜当下,勇敢前行。`;

    this.setData({ overallMeaning: overall });
  },

  // 重置
  reset() {
    this.setData({
      step: 0,
      drawnCards: [],
      overallMeaning: ''
    });
  },

  // 保存记录
  saveRecord() {
    const record = {
      type: 'three',
      cards: this.data.drawnCards,
      overallMeaning: this.data.overallMeaning
    };

    const success = saveDivinationRecord(record);

    wx.showToast({
      title: success ? '保存成功' : '保存失败',
      icon: success ? 'success' : 'none'
    });
  }
});
