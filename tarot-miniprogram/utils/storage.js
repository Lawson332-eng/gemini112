// utils/storage.js - 本地存储工具函数封装

/**
 * 保存占卜记录到本地存储
 * @param {object} record - 占卜记录对象
 * @param {string} record.type - 占卜类型（single/three）
 * @param {array} record.cards - 抽到的牌数组
 * @param {string} record.question - 占卜问题（可选）
 */
function saveDivinationRecord(record) {
  try {
    // 获取现有历史记录
    let history = wx.getStorageSync('divination_history') || [];

    // 添加时间戳
    const newRecord = {
      ...record,
      timestamp: Date.now(),
      date: formatDate(new Date())
    };

    // 将新记录添加到数组开头
    history.unshift(newRecord);

    // 限制历史记录数量（最多保存100条）
    if (history.length > 100) {
      history = history.slice(0, 100);
    }

    // 保存到本地存储
    wx.setStorageSync('divination_history', history);

    return true;
  } catch (e) {
    console.error('保存占卜记录失败:', e);
    return false;
  }
}

/**
 * 获取所有占卜历史记录
 * @returns {array} 历史记录数组
 */
function getDivinationHistory() {
  try {
    return wx.getStorageSync('divination_history') || [];
  } catch (e) {
    console.error('获取占卜历史失败:', e);
    return [];
  }
}

/**
 * 删除指定的占卜记录
 * @param {number} timestamp - 记录的时间戳
 * @returns {boolean} 是否删除成功
 */
function deleteDivinationRecord(timestamp) {
  try {
    let history = getDivinationHistory();
    history = history.filter(record => record.timestamp !== timestamp);
    wx.setStorageSync('divination_history', history);
    return true;
  } catch (e) {
    console.error('删除占卜记录失败:', e);
    return false;
  }
}

/**
 * 清空所有占卜历史
 * @returns {boolean} 是否清空成功
 */
function clearDivinationHistory() {
  try {
    wx.setStorageSync('divination_history', []);
    return true;
  } catch (e) {
    console.error('清空历史记录失败:', e);
    return false;
  }
}

/**
 * 保存每日一卡
 * @param {object} cardData - 卡牌数据
 * @returns {boolean} 是否保存成功
 */
function saveDailyCard(cardData) {
  try {
    const today = formatDate(new Date(), 'YYYY-MM-DD');
    const dailyCard = {
      date: today,
      card: cardData,
      timestamp: Date.now()
    };
    wx.setStorageSync('daily_card', dailyCard);
    return true;
  } catch (e) {
    console.error('保存每日一卡失败:', e);
    return false;
  }
}

/**
 * 获取每日一卡
 * @returns {object|null} 每日卡牌数据，如果今天还没有则返回null
 */
function getDailyCard() {
  try {
    const dailyCard = wx.getStorageSync('daily_card');
    if (!dailyCard) return null;

    const today = formatDate(new Date(), 'YYYY-MM-DD');
    // 检查是否是今天的卡牌
    if (dailyCard.date === today) {
      return dailyCard;
    }
    return null;
  } catch (e) {
    console.error('获取每日一卡失败:', e);
    return null;
  }
}

/**
 * 格式化日期
 * @param {Date} date - 日期对象
 * @param {string} format - 格式（默认：'YYYY-MM-DD HH:mm:ss'）
 * @returns {string} 格式化后的日期字符串
 */
function formatDate(date, format = 'YYYY-MM-DD HH:mm:ss') {
  const year = date.getFullYear();
  const month = String(date.getMonth() + 1).padStart(2, '0');
  const day = String(date.getDate()).padStart(2, '0');
  const hours = String(date.getHours()).padStart(2, '0');
  const minutes = String(date.getMinutes()).padStart(2, '0');
  const seconds = String(date.getSeconds()).padStart(2, '0');

  return format
    .replace('YYYY', year)
    .replace('MM', month)
    .replace('DD', day)
    .replace('HH', hours)
    .replace('mm', minutes)
    .replace('ss', seconds);
}

/**
 * 获取相对时间描述
 * @param {number} timestamp - 时间戳
 * @returns {string} 相对时间描述（如："刚刚"、"5分钟前"等）
 */
function getRelativeTime(timestamp) {
  const now = Date.now();
  const diff = now - timestamp;

  const minute = 60 * 1000;
  const hour = 60 * minute;
  const day = 24 * hour;
  const week = 7 * day;

  if (diff < minute) {
    return '刚刚';
  } else if (diff < hour) {
    return `${Math.floor(diff / minute)}分钟前`;
  } else if (diff < day) {
    return `${Math.floor(diff / hour)}小时前`;
  } else if (diff < week) {
    return `${Math.floor(diff / day)}天前`;
  } else {
    return formatDate(new Date(timestamp), 'YYYY-MM-DD');
  }
}

module.exports = {
  saveDivinationRecord,
  getDivinationHistory,
  deleteDivinationRecord,
  clearDivinationHistory,
  saveDailyCard,
  getDailyCard,
  formatDate,
  getRelativeTime
};
