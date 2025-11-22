// data/tarot-cards.js - 塔罗牌完整数据库（78张牌）

/**
 * 塔罗牌数据结构：
 * - id: 唯一标识
 * - name: 牌名（中文）
 * - nameEn: 牌名（英文）
 * - type: 类型（major大阿卡纳 / minor小阿卡纳）
 * - suit: 花色（仅小阿卡纳：wands权杖/cups圣杯/swords宝剑/pentacles星币）
 * - number: 序号
 * - keywords: 关键词数组
 * - image: 图片路径（实际项目中需要准备真实图片）
 */

const TAROT_CARDS = [
  // ========== 大阿卡纳（Major Arcana）22张 ==========
  {
    id: 0,
    name: '愚者',
    nameEn: 'The Fool',
    type: 'major',
    suit: null,
    number: 0,
    keywords: ['新开始', '冒险', '纯真', '自由', '潜力'],
    image: '/static/images/cards/major/00-fool.png'
  },
  {
    id: 1,
    name: '魔术师',
    nameEn: 'The Magician',
    type: 'major',
    suit: null,
    number: 1,
    keywords: ['创造力', '技能', '意志力', '沟通', '行动'],
    image: '/static/images/cards/major/01-magician.png'
  },
  {
    id: 2,
    name: '女祭司',
    nameEn: 'The High Priestess',
    type: 'major',
    suit: null,
    number: 2,
    keywords: ['直觉', '潜意识', '神秘', '智慧', '内在'],
    image: '/static/images/cards/major/02-high-priestess.png'
  },
  {
    id: 3,
    name: '皇后',
    nameEn: 'The Empress',
    type: 'major',
    suit: null,
    number: 3,
    keywords: ['丰盛', '母性', '创造', '美丽', '自然'],
    image: '/static/images/cards/major/03-empress.png'
  },
  {
    id: 4,
    name: '皇帝',
    nameEn: 'The Emperor',
    type: 'major',
    suit: null,
    number: 4,
    keywords: ['权威', '结构', '控制', '稳定', '父性'],
    image: '/static/images/cards/major/04-emperor.png'
  },
  {
    id: 5,
    name: '教皇',
    nameEn: 'The Hierophant',
    type: 'major',
    suit: null,
    number: 5,
    keywords: ['传统', '信仰', '教导', '遵循', '仪式'],
    image: '/static/images/cards/major/05-hierophant.png'
  },
  {
    id: 6,
    name: '恋人',
    nameEn: 'The Lovers',
    type: 'major',
    suit: null,
    number: 6,
    keywords: ['爱情', '选择', '关系', '和谐', '价值观'],
    image: '/static/images/cards/major/06-lovers.png'
  },
  {
    id: 7,
    name: '战车',
    nameEn: 'The Chariot',
    type: 'major',
    suit: null,
    number: 7,
    keywords: ['胜利', '意志力', '决心', '前进', '控制'],
    image: '/static/images/cards/major/07-chariot.png'
  },
  {
    id: 8,
    name: '力量',
    nameEn: 'Strength',
    type: 'major',
    suit: null,
    number: 8,
    keywords: ['勇气', '耐心', '温柔', '内在力量', '驯服'],
    image: '/static/images/cards/major/08-strength.png'
  },
  {
    id: 9,
    name: '隐士',
    nameEn: 'The Hermit',
    type: 'major',
    suit: null,
    number: 9,
    keywords: ['独处', '内省', '智慧', '指引', '寻找'],
    image: '/static/images/cards/major/09-hermit.png'
  },
  {
    id: 10,
    name: '命运之轮',
    nameEn: 'Wheel of Fortune',
    type: 'major',
    suit: null,
    number: 10,
    keywords: ['命运', '变化', '循环', '机遇', '转折'],
    image: '/static/images/cards/major/10-wheel-of-fortune.png'
  },
  {
    id: 11,
    name: '正义',
    nameEn: 'Justice',
    type: 'major',
    suit: null,
    number: 11,
    keywords: ['公平', '真相', '法律', '因果', '平衡'],
    image: '/static/images/cards/major/11-justice.png'
  },
  {
    id: 12,
    name: '倒吊人',
    nameEn: 'The Hanged Man',
    type: 'major',
    suit: null,
    number: 12,
    keywords: ['暂停', '牺牲', '换角度', '顿悟', '等待'],
    image: '/static/images/cards/major/12-hanged-man.png'
  },
  {
    id: 13,
    name: '死神',
    nameEn: 'Death',
    type: 'major',
    suit: null,
    number: 13,
    keywords: ['结束', '转变', '重生', '放手', '新篇章'],
    image: '/static/images/cards/major/13-death.png'
  },
  {
    id: 14,
    name: '节制',
    nameEn: 'Temperance',
    type: 'major',
    suit: null,
    number: 14,
    keywords: ['平衡', '和谐', '耐心', '融合', '中庸'],
    image: '/static/images/cards/major/14-temperance.png'
  },
  {
    id: 15,
    name: '恶魔',
    nameEn: 'The Devil',
    type: 'major',
    suit: null,
    number: 15,
    keywords: ['束缚', '诱惑', '物质', '依赖', '阴影'],
    image: '/static/images/cards/major/15-devil.png'
  },
  {
    id: 16,
    name: '塔',
    nameEn: 'The Tower',
    type: 'major',
    suit: null,
    number: 16,
    keywords: ['突变', '崩溃', '启示', '破旧立新', '震撼'],
    image: '/static/images/cards/major/16-tower.png'
  },
  {
    id: 17,
    name: '星星',
    nameEn: 'The Star',
    type: 'major',
    suit: null,
    number: 17,
    keywords: ['希望', '启发', '宁静', '信念', '治愈'],
    image: '/static/images/cards/major/17-star.png'
  },
  {
    id: 18,
    name: '月亮',
    nameEn: 'The Moon',
    type: 'major',
    suit: null,
    number: 18,
    keywords: ['幻想', '恐惧', '潜意识', '不确定', '迷惑'],
    image: '/static/images/cards/major/18-moon.png'
  },
  {
    id: 19,
    name: '太阳',
    nameEn: 'The Sun',
    type: 'major',
    suit: null,
    number: 19,
    keywords: ['成功', '活力', '喜悦', '光明', '真实'],
    image: '/static/images/cards/major/19-sun.png'
  },
  {
    id: 20,
    name: '审判',
    nameEn: 'Judgement',
    type: 'major',
    suit: null,
    number: 20,
    keywords: ['觉醒', '复活', '评判', '决定', '召唤'],
    image: '/static/images/cards/major/20-judgement.png'
  },
  {
    id: 21,
    name: '世界',
    nameEn: 'The World',
    type: 'major',
    suit: null,
    number: 21,
    keywords: ['完成', '成就', '圆满', '整合', '旅程终点'],
    image: '/static/images/cards/major/21-world.png'
  },

  // ========== 小阿卡纳 - 权杖（Wands）14张 ==========
  {
    id: 22,
    name: '权杖王牌',
    nameEn: 'Ace of Wands',
    type: 'minor',
    suit: 'wands',
    number: 1,
    keywords: ['新机会', '灵感', '成长', '潜力', '创新'],
    image: '/static/images/cards/minor/wands-01.png'
  },
  {
    id: 23,
    name: '权杖二',
    nameEn: 'Two of Wands',
    type: 'minor',
    suit: 'wands',
    number: 2,
    keywords: ['计划', '决策', '探索', '远见', '发现'],
    image: '/static/images/cards/minor/wands-02.png'
  },
  {
    id: 24,
    name: '权杖三',
    nameEn: 'Three of Wands',
    type: 'minor',
    suit: 'wands',
    number: 3,
    keywords: ['扩展', '远见', '进展', '领导', '远方'],
    image: '/static/images/cards/minor/wands-03.png'
  },
  {
    id: 25,
    name: '权杖四',
    nameEn: 'Four of Wands',
    type: 'minor',
    suit: 'wands',
    number: 4,
    keywords: ['庆祝', '和谐', '家庭', '喜悦', '稳定'],
    image: '/static/images/cards/minor/wands-04.png'
  },
  {
    id: 26,
    name: '权杖五',
    nameEn: 'Five of Wands',
    type: 'minor',
    suit: 'wands',
    number: 5,
    keywords: ['竞争', '冲突', '挑战', '不和', '争论'],
    image: '/static/images/cards/minor/wands-05.png'
  },
  {
    id: 27,
    name: '权杖六',
    nameEn: 'Six of Wands',
    type: 'minor',
    suit: 'wands',
    number: 6,
    keywords: ['胜利', '荣誉', '认可', '成功', '公众'],
    image: '/static/images/cards/minor/wands-06.png'
  },
  {
    id: 28,
    name: '权杖七',
    nameEn: 'Seven of Wands',
    type: 'minor',
    suit: 'wands',
    number: 7,
    keywords: ['防守', '挑战', '坚持', '竞争', '勇气'],
    image: '/static/images/cards/minor/wands-07.png'
  },
  {
    id: 29,
    name: '权杖八',
    nameEn: 'Eight of Wands',
    type: 'minor',
    suit: 'wands',
    number: 8,
    keywords: ['快速', '行动', '消息', '旅行', '进展'],
    image: '/static/images/cards/minor/wands-08.png'
  },
  {
    id: 30,
    name: '权杖九',
    nameEn: 'Nine of Wands',
    type: 'minor',
    suit: 'wands',
    number: 9,
    keywords: ['防御', '坚韧', '警惕', '最后努力', '恢复'],
    image: '/static/images/cards/minor/wands-09.png'
  },
  {
    id: 31,
    name: '权杖十',
    nameEn: 'Ten of Wands',
    type: 'minor',
    suit: 'wands',
    number: 10,
    keywords: ['负担', '责任', '压力', '完成', '艰辛'],
    image: '/static/images/cards/minor/wands-10.png'
  },
  {
    id: 32,
    name: '权杖侍者',
    nameEn: 'Page of Wands',
    type: 'minor',
    suit: 'wands',
    number: 11,
    keywords: ['探索', '冒险', '热情', '消息', '自由'],
    image: '/static/images/cards/minor/wands-page.png'
  },
  {
    id: 33,
    name: '权杖骑士',
    nameEn: 'Knight of Wands',
    type: 'minor',
    suit: 'wands',
    number: 12,
    keywords: ['行动', '冲动', '冒险', '激情', '变化'],
    image: '/static/images/cards/minor/wands-knight.png'
  },
  {
    id: 34,
    name: '权杖王后',
    nameEn: 'Queen of Wands',
    type: 'minor',
    suit: 'wands',
    number: 13,
    keywords: ['自信', '热情', '独立', '魅力', '决心'],
    image: '/static/images/cards/minor/wands-queen.png'
  },
  {
    id: 35,
    name: '权杖国王',
    nameEn: 'King of Wands',
    type: 'minor',
    suit: 'wands',
    number: 14,
    keywords: ['领导', '远见', '企业家', '荣誉', '果断'],
    image: '/static/images/cards/minor/wands-king.png'
  },

  // ========== 小阿卡纳 - 圣杯（Cups）14张 ==========
  {
    id: 36,
    name: '圣杯王牌',
    nameEn: 'Ace of Cups',
    type: 'minor',
    suit: 'cups',
    number: 1,
    keywords: ['爱', '情感', '直觉', '创造力', '新感情'],
    image: '/static/images/cards/minor/cups-01.png'
  },
  {
    id: 37,
    name: '圣杯二',
    nameEn: 'Two of Cups',
    type: 'minor',
    suit: 'cups',
    number: 2,
    keywords: ['伙伴关系', '结合', '吸引', '和谐', '爱情'],
    image: '/static/images/cards/minor/cups-02.png'
  },
  {
    id: 38,
    name: '圣杯三',
    nameEn: 'Three of Cups',
    type: 'minor',
    suit: 'cups',
    number: 3,
    keywords: ['庆祝', '友谊', '团体', '聚会', '喜悦'],
    image: '/static/images/cards/minor/cups-03.png'
  },
  {
    id: 39,
    name: '圣杯四',
    nameEn: 'Four of Cups',
    type: 'minor',
    suit: 'cups',
    number: 4,
    keywords: ['冥想', '沉思', '冷漠', '重新评估', '退缩'],
    image: '/static/images/cards/minor/cups-04.png'
  },
  {
    id: 40,
    name: '圣杯五',
    nameEn: 'Five of Cups',
    type: 'minor',
    suit: 'cups',
    number: 5,
    keywords: ['失望', '悲伤', '遗憾', '损失', '专注过去'],
    image: '/static/images/cards/minor/cups-05.png'
  },
  {
    id: 41,
    name: '圣杯六',
    nameEn: 'Six of Cups',
    type: 'minor',
    suit: 'cups',
    number: 6,
    keywords: ['怀旧', '童年', '纯真', '回忆', '重逢'],
    image: '/static/images/cards/minor/cups-06.png'
  },
  {
    id: 42,
    name: '圣杯七',
    nameEn: 'Seven of Cups',
    type: 'minor',
    suit: 'cups',
    number: 7,
    keywords: ['选择', '幻想', '白日梦', '混乱', '机会'],
    image: '/static/images/cards/minor/cups-07.png'
  },
  {
    id: 43,
    name: '圣杯八',
    nameEn: 'Eight of Cups',
    type: 'minor',
    suit: 'cups',
    number: 8,
    keywords: ['离开', '撤退', '寻找', '放弃', '前进'],
    image: '/static/images/cards/minor/cups-08.png'
  },
  {
    id: 44,
    name: '圣杯九',
    nameEn: 'Nine of Cups',
    type: 'minor',
    suit: 'cups',
    number: 9,
    keywords: ['满足', '愿望成真', '幸福', '享受', '成就'],
    image: '/static/images/cards/minor/cups-09.png'
  },
  {
    id: 45,
    name: '圣杯十',
    nameEn: 'Ten of Cups',
    type: 'minor',
    suit: 'cups',
    number: 10,
    keywords: ['和谐', '家庭', '幸福', '满足', '情感圆满'],
    image: '/static/images/cards/minor/cups-10.png'
  },
  {
    id: 46,
    name: '圣杯侍者',
    nameEn: 'Page of Cups',
    type: 'minor',
    suit: 'cups',
    number: 11,
    keywords: ['创意', '直觉', '好奇', '温柔', '消息'],
    image: '/static/images/cards/minor/cups-page.png'
  },
  {
    id: 47,
    name: '圣杯骑士',
    nameEn: 'Knight of Cups',
    type: 'minor',
    suit: 'cups',
    number: 12,
    keywords: ['浪漫', '魅力', '想象', '情感', '邀请'],
    image: '/static/images/cards/minor/cups-knight.png'
  },
  {
    id: 48,
    name: '圣杯王后',
    nameEn: 'Queen of Cups',
    type: 'minor',
    suit: 'cups',
    number: 13,
    keywords: ['同情', '关怀', '情感成熟', '直觉', '温暖'],
    image: '/static/images/cards/minor/cups-queen.png'
  },
  {
    id: 49,
    name: '圣杯国王',
    nameEn: 'King of Cups',
    type: 'minor',
    suit: 'cups',
    number: 14,
    keywords: ['情感平衡', '外交', '关怀', '冷静', '智慧'],
    image: '/static/images/cards/minor/cups-king.png'
  },

  // ========== 小阿卡纳 - 宝剑（Swords）14张 ==========
  {
    id: 50,
    name: '宝剑王牌',
    nameEn: 'Ace of Swords',
    type: 'minor',
    suit: 'swords',
    number: 1,
    keywords: ['突破', '清晰', '真相', '智慧', '新想法'],
    image: '/static/images/cards/minor/swords-01.png'
  },
  {
    id: 51,
    name: '宝剑二',
    nameEn: 'Two of Swords',
    type: 'minor',
    suit: 'swords',
    number: 2,
    keywords: ['僵局', '困境', '逃避', '选择', '平衡'],
    image: '/static/images/cards/minor/swords-02.png'
  },
  {
    id: 52,
    name: '宝剑三',
    nameEn: 'Three of Swords',
    type: 'minor',
    suit: 'swords',
    number: 3,
    keywords: ['心碎', '悲伤', '痛苦', '分离', '释放'],
    image: '/static/images/cards/minor/swords-03.png'
  },
  {
    id: 53,
    name: '宝剑四',
    nameEn: 'Four of Swords',
    type: 'minor',
    suit: 'swords',
    number: 4,
    keywords: ['休息', '恢复', '沉思', '暂停', '和平'],
    image: '/static/images/cards/minor/swords-04.png'
  },
  {
    id: 54,
    name: '宝剑五',
    nameEn: 'Five of Swords',
    type: 'minor',
    suit: 'swords',
    number: 5,
    keywords: ['冲突', '失败', '背叛', '赢得代价', '紧张'],
    image: '/static/images/cards/minor/swords-05.png'
  },
  {
    id: 55,
    name: '宝剑六',
    nameEn: 'Six of Swords',
    type: 'minor',
    suit: 'swords',
    number: 6,
    keywords: ['过渡', '移动', '离开', '旅程', '改变'],
    image: '/static/images/cards/minor/swords-06.png'
  },
  {
    id: 56,
    name: '宝剑七',
    nameEn: 'Seven of Swords',
    type: 'minor',
    suit: 'swords',
    number: 7,
    keywords: ['策略', '欺骗', '狡猾', '逃避', '单独行动'],
    image: '/static/images/cards/minor/swords-07.png'
  },
  {
    id: 57,
    name: '宝剑八',
    nameEn: 'Eight of Swords',
    type: 'minor',
    suit: 'swords',
    number: 8,
    keywords: ['限制', '束缚', '受困', '恐惧', '无力'],
    image: '/static/images/cards/minor/swords-08.png'
  },
  {
    id: 58,
    name: '宝剑九',
    nameEn: 'Nine of Swords',
    type: 'minor',
    suit: 'swords',
    number: 9,
    keywords: ['焦虑', '担忧', '恐惧', '失眠', '压力'],
    image: '/static/images/cards/minor/swords-09.png'
  },
  {
    id: 59,
    name: '宝剑十',
    nameEn: 'Ten of Swords',
    type: 'minor',
    suit: 'swords',
    number: 10,
    keywords: ['结束', '失败', '背叛', '触底', '转折点'],
    image: '/static/images/cards/minor/swords-10.png'
  },
  {
    id: 60,
    name: '宝剑侍者',
    nameEn: 'Page of Swords',
    type: 'minor',
    suit: 'swords',
    number: 11,
    keywords: ['好奇', '警觉', '思想', '消息', '监视'],
    image: '/static/images/cards/minor/swords-page.png'
  },
  {
    id: 61,
    name: '宝剑骑士',
    nameEn: 'Knight of Swords',
    type: 'minor',
    suit: 'swords',
    number: 12,
    keywords: ['行动', '冲动', '直接', '雄心', '急躁'],
    image: '/static/images/cards/minor/swords-knight.png'
  },
  {
    id: 62,
    name: '宝剑王后',
    nameEn: 'Queen of Swords',
    type: 'minor',
    suit: 'swords',
    number: 13,
    keywords: ['独立', '清晰', '智慧', '客观', '洞察'],
    image: '/static/images/cards/minor/swords-queen.png'
  },
  {
    id: 63,
    name: '宝剑国王',
    nameEn: 'King of Swords',
    type: 'minor',
    suit: 'swords',
    number: 14,
    keywords: ['权威', '真相', '智力', '清晰', '决断'],
    image: '/static/images/cards/minor/swords-king.png'
  },

  // ========== 小阿卡纳 - 星币（Pentacles）14张 ==========
  {
    id: 64,
    name: '星币王牌',
    nameEn: 'Ace of Pentacles',
    type: 'minor',
    suit: 'pentacles',
    number: 1,
    keywords: ['机会', '繁荣', '新事业', '财富', '显化'],
    image: '/static/images/cards/minor/pentacles-01.png'
  },
  {
    id: 65,
    name: '星币二',
    nameEn: 'Two of Pentacles',
    type: 'minor',
    suit: 'pentacles',
    number: 2,
    keywords: ['平衡', '多任务', '适应', '灵活', '优先'],
    image: '/static/images/cards/minor/pentacles-02.png'
  },
  {
    id: 66,
    name: '星币三',
    nameEn: 'Three of Pentacles',
    type: 'minor',
    suit: 'pentacles',
    number: 3,
    keywords: ['团队合作', '协作', '技能', '质量', '建设'],
    image: '/static/images/cards/minor/pentacles-03.png'
  },
  {
    id: 67,
    name: '星币四',
    nameEn: 'Four of Pentacles',
    type: 'minor',
    suit: 'pentacles',
    number: 4,
    keywords: ['控制', '稳定', '占有', '节俭', '保护'],
    image: '/static/images/cards/minor/pentacles-04.png'
  },
  {
    id: 68,
    name: '星币五',
    nameEn: 'Five of Pentacles',
    type: 'minor',
    suit: 'pentacles',
    number: 5,
    keywords: ['困难', '损失', '孤立', '担忧', '考验'],
    image: '/static/images/cards/minor/pentacles-05.png'
  },
  {
    id: 69,
    name: '星币六',
    nameEn: 'Six of Pentacles',
    type: 'minor',
    suit: 'pentacles',
    number: 6,
    keywords: ['慷慨', '给予', '接受', '分享', '慈善'],
    image: '/static/images/cards/minor/pentacles-06.png'
  },
  {
    id: 70,
    name: '星币七',
    nameEn: 'Seven of Pentacles',
    type: 'minor',
    suit: 'pentacles',
    number: 7,
    keywords: ['评估', '耐心', '投资', '反思', '奖励'],
    image: '/static/images/cards/minor/pentacles-07.png'
  },
  {
    id: 71,
    name: '星币八',
    nameEn: 'Eight of Pentacles',
    type: 'minor',
    suit: 'pentacles',
    number: 8,
    keywords: ['技艺', '努力', '专注', '技能', '勤奋'],
    image: '/static/images/cards/minor/pentacles-08.png'
  },
  {
    id: 72,
    name: '星币九',
    nameEn: 'Nine of Pentacles',
    type: 'minor',
    suit: 'pentacles',
    number: 9,
    keywords: ['独立', '财富', '自给自足', '享受', '成就'],
    image: '/static/images/cards/minor/pentacles-09.png'
  },
  {
    id: 73,
    name: '星币十',
    nameEn: 'Ten of Pentacles',
    type: 'minor',
    suit: 'pentacles',
    number: 10,
    keywords: ['财富', '家庭', '传承', '稳定', '成功'],
    image: '/static/images/cards/minor/pentacles-10.png'
  },
  {
    id: 74,
    name: '星币侍者',
    nameEn: 'Page of Pentacles',
    type: 'minor',
    suit: 'pentacles',
    number: 11,
    keywords: ['机会', '学习', '显化', '消息', '野心'],
    image: '/static/images/cards/minor/pentacles-page.png'
  },
  {
    id: 75,
    name: '星币骑士',
    nameEn: 'Knight of Pentacles',
    type: 'minor',
    suit: 'pentacles',
    number: 12,
    keywords: ['效率', '勤奋', '责任', '务实', '常规'],
    image: '/static/images/cards/minor/pentacles-knight.png'
  },
  {
    id: 76,
    name: '星币王后',
    nameEn: 'Queen of Pentacles',
    type: 'minor',
    suit: 'pentacles',
    number: 13,
    keywords: ['养育', '务实', '安全', '舒适', '富足'],
    image: '/static/images/cards/minor/pentacles-queen.png'
  },
  {
    id: 77,
    name: '星币国王',
    nameEn: 'King of Pentacles',
    type: 'minor',
    suit: 'pentacles',
    number: 14,
    keywords: ['财富', '商业', '成功', '安全', '控制'],
    image: '/static/images/cards/minor/pentacles-king.png'
  }
];

// 导出数据
module.exports = {
  TAROT_CARDS,
  // 辅助函数：根据ID获取牌
  getCardById: (id) => {
    return TAROT_CARDS.find(card => card.id === id);
  },
  // 辅助函数：获取所有大阿卡纳
  getMajorArcana: () => {
    return TAROT_CARDS.filter(card => card.type === 'major');
  },
  // 辅助函数：获取所有小阿卡纳
  getMinorArcana: () => {
    return TAROT_CARDS.filter(card => card.type === 'minor');
  },
  // 辅助函数：根据花色获取牌
  getCardsBySuit: (suit) => {
    return TAROT_CARDS.filter(card => card.suit === suit);
  }
};
