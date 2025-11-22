// pages/history/history.js
const { getDivinationHistory, deleteDivinationRecord, clearDivinationHistory, getRelativeTime } = require('../../utils/storage.js');

Page({
  data: {
    historyList: []
  },

  onLoad() {
    this.loadHistory();
  },

  onShow() {
    this.loadHistory();
  },

  // 加载历史记录
  loadHistory() {
    const history = getDivinationHistory();

    // 添加相对时间
    const historyWithTime = history.map(record => ({
      ...record,
      relativeTime: getRelativeTime(record.timestamp)
    }));

    this.setData({ historyList: historyWithTime });
  },

  // 查看详情
  viewDetail(e) {
    const index = e.currentTarget.dataset.index;
    const record = this.data.historyList[index];

    wx.showModal({
      title: record.type === 'single' ? '单牌占卜' : '三牌阵占卜',
      content: `抽到的牌：${record.cards.map(c => c.name).join('、')}`,
      showCancel: false
    });
  },

  // 删除记录
  deleteRecord(e) {
    const timestamp = e.currentTarget.dataset.timestamp;

    wx.showModal({
      title: '确认删除',
      content: '是否删除此条记录？',
      success: (res) => {
        if (res.confirm) {
          const success = deleteDivinationRecord(timestamp);
          if (success) {
            wx.showToast({
              title: '删除成功',
              icon: 'success'
            });
            this.loadHistory();
          }
        }
      }
    });
  },

  // 清空所有记录
  clearHistory() {
    wx.showModal({
      title: '确认清空',
      content: '是否清空所有占卜记录？',
      success: (res) => {
        if (res.confirm) {
          const success = clearDivinationHistory();
          if (success) {
            wx.showToast({
              title: '清空成功',
              icon: 'success'
            });
            this.loadHistory();
          }
        }
      }
    });
  }
});
