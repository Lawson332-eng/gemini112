// utils/card-shuffle.js - 洗牌算法工具函数

const { TAROT_CARDS } = require('../data/tarot-cards.js');

/**
 * Fisher-Yates 洗牌算法
 * @param {array} array - 要打乱的数组
 * @returns {array} 打乱后的数组
 */
function shuffleArray(array) {
  const newArray = [...array]; // 创建副本,避免修改原数组

  for (let i = newArray.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [newArray[i], newArray[j]] = [newArray[j], newArray[i]];
  }

  return newArray;
}

/**
 * 洗塔罗牌
 * @returns {array} 打乱后的塔罗牌数组
 */
function shuffleTarotCards() {
  return shuffleArray(TAROT_CARDS);
}

/**
 * 抽取指定数量的塔罗牌
 * @param {number} count - 要抽取的牌数
 * @param {boolean} allowReversed - 是否允许逆位（默认：true）
 * @returns {array} 抽取的牌数组，每张牌包含卡牌信息和是否逆位
 */
function drawCards(count = 1, allowReversed = true) {
  // 洗牌
  const shuffledCards = shuffleTarotCards();

  // 抽取指定数量的牌
  const drawnCards = shuffledCards.slice(0, count);

  // 为每张牌随机决定是否逆位
  return drawnCards.map(card => ({
    ...card,
    isReversed: allowReversed ? Math.random() < 0.3 : false // 30%概率逆位
  }));
}

/**
 * 抽取单张塔罗牌
 * @param {boolean} allowReversed - 是否允许逆位（默认：true）
 * @returns {object} 抽取的牌对象
 */
function drawSingleCard(allowReversed = true) {
  return drawCards(1, allowReversed)[0];
}

/**
 * 抽取三张牌（用于三牌阵）
 * @param {boolean} allowReversed - 是否允许逆位（默认：true）
 * @returns {array} 三张牌数组 [过去, 现在, 未来]
 */
function drawThreeCards(allowReversed = true) {
  const cards = drawCards(3, allowReversed);
  return [
    { ...cards[0], position: 'past', positionName: '过去' },
    { ...cards[1], position: 'present', positionName: '现在' },
    { ...cards[2], position: 'future', positionName: '未来' }
  ];
}

/**
 * 从指定范围随机抽取一张牌
 * @param {string} type - 类型（'major'大阿卡纳 或 'minor'小阿卡纳）
 * @param {boolean} allowReversed - 是否允许逆位
 * @returns {object} 抽取的牌对象
 */
function drawCardByType(type = 'all', allowReversed = true) {
  let cardPool = TAROT_CARDS;

  if (type === 'major') {
    cardPool = TAROT_CARDS.filter(card => card.type === 'major');
  } else if (type === 'minor') {
    cardPool = TAROT_CARDS.filter(card => card.type === 'minor');
  }

  const shuffled = shuffleArray(cardPool);
  const card = shuffled[0];

  return {
    ...card,
    isReversed: allowReversed ? Math.random() < 0.3 : false
  };
}

/**
 * 生成每日一卡（固定种子,确保同一天抽到相同的牌）
 * @param {string} dateStr - 日期字符串（格式：YYYY-MM-DD）
 * @returns {object} 每日卡牌对象
 */
function generateDailyCard(dateStr) {
  // 使用日期作为种子生成固定随机数
  const seed = dateStr.split('-').join('');
  const pseudoRandom = parseInt(seed) % TAROT_CARDS.length;

  const card = TAROT_CARDS[pseudoRandom];

  // 根据日期的最后一位数字决定是否逆位
  const lastDigit = parseInt(seed.slice(-1));
  const isReversed = lastDigit < 3; // 0,1,2 逆位，其他正位

  return {
    ...card,
    isReversed
  };
}

module.exports = {
  shuffleArray,
  shuffleTarotCards,
  drawCards,
  drawSingleCard,
  drawThreeCards,
  drawCardByType,
  generateDailyCard
};
