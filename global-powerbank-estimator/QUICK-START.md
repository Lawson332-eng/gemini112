# WordPress 快速部署 - 5分钟完成

## 🚀 只需3步，立即部署！

---

## 第一步：上传文件 (2分钟)

### 通过FTP/文件管理器：

1. 打开您的FTP软件或主机文件管理器

2. 导航到：
   ```
   /wp-content/themes/你的主题名称/
   ```

3. 创建文件夹：`powerbank-calculator`

4. 上传这3个文件：
   - ✅ `embed.html`
   - ✅ `script.js`
   - ✅ `data.json`

**完成后路径应该是：**
```
/wp-content/themes/你的主题/powerbank-calculator/
├── embed.html
├── script.js
└── data.json
```

---

## 第二步：添加代码 (1分钟)

1. 登录WordPress后台

2. 进入：**外观** > **主题文件编辑器**

3. 选择右侧的：**主题函数 (functions.php)**

4. 滚动到文件最底部

5. 复制粘贴以下代码：

```php
// 充电宝市场预估工具
function powerbank_calculator_shortcode() {
    wp_enqueue_script('tailwind', 'https://cdn.tailwindcss.com');
    wp_enqueue_script('chartjs', 'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js');
    wp_enqueue_script('jspdf', 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js');
    wp_enqueue_script('powerbank-calc', get_template_directory_uri() . '/powerbank-calculator/script.js', array('chartjs'), '1.0', true);

    ob_start();
    include(get_template_directory() . '/powerbank-calculator/embed.html');
    return ob_get_clean();
}
add_shortcode('powerbank_calculator', 'powerbank_calculator_shortcode');
```

6. 点击：**更新文件**

---

## 第三步：创建页面 (2分钟)

1. 进入：**页面** > **新建页面**

2. 输入标题：
   ```
   市场容量预估工具
   ```

3. 在内容区域输入短代码：
   ```
   [powerbank_calculator]
   ```

   **注意：**
   - 如果使用古腾堡编辑器：点击 **+** > 选择 **短代码** 块 > 输入上面的短代码
   - 如果使用经典编辑器：切换到 **文本** 模式 > 输入上面的短代码

4. （可选）在右侧设置：
   - **模板**: 选择"全宽"或"Canvas"（如果有）
   - **固定链接**: 改为 `market-estimator`

5. 点击：**发布**

6. 点击：**查看页面**

---

## ✅ 完成！

您现在应该看到工具正常运行了！

### 功能测试：

- ✅ 可以选择参考城市
- ✅ 可以切换语言（中文/英文）
- ✅ 可以输入数据并计算
- ✅ 可以看到图表
- ✅ 可以导出PDF/Excel

---

## ⚠️ 如果遇到问题

### 问题1: 显示"找不到文件"

**原因**: 文件路径不对

**解决**:
1. 确认文件上传到了正确位置
2. 检查主题名称是否正确
3. 尝试刷新页面

### 问题2: 页面空白

**原因**: 代码有错误

**解决**:
1. 检查functions.php中的代码是否完整
2. 确保没有多余的空格或字符
3. 查看浏览器控制台（按F12）是否有错误

### 问题3: 样式错乱

**原因**: 主题样式冲突

**解决**:
1. 选择"全宽"页面模板
2. 清除缓存（如果使用缓存插件）
3. 刷新浏览器

---

## 📱 页面链接

工具页面默认地址：
```
https://你的网站.com/market-estimator/
```

您可以：
- 添加到主菜单
- 分享给用户
- 嵌入到其他页面

---

## 🎨 自定义颜色

如果想修改颜色，编辑 `embed.html` 文件中的这部分：

```css
:root {
    --primary: #070346;    /* 主色 */
    --secondary: #FE714C;  /* 强调色 */
    --accent: #E6F0EC;     /* 辅助色 */
}
```

---

## 📞 需要详细教程？

查看完整文档：
- **WORDPRESS-SETUP.md** - 详细部署指南
- **README.md** - 功能说明
- **DEPLOYMENT.md** - 高级配置

---

**就这么简单！享受您的新工具吧！** 🎉
