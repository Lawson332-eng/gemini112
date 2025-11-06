# WordPress集成 - 5分钟快速开始

最简单快速的WordPress集成方法。

## 🚀 方法一：iframe嵌入（最推荐）

### 难度：⭐ (最简单)
### 时间：5分钟

#### 步骤1：上传计算器文件

**选项A：上传到主题目录**
```
wp-content/themes/你的主题名/roi-calculator/
└── index.html (从 public/index.html 复制)
```

**选项B：上传到uploads目录**
```
wp-content/uploads/roi-calculator/
└── index.html
```

**如何上传？**
1. 通过FTP工具（如FileZilla）
2. 或通过WordPress后台 → 媒体 → 文件管理器插件
3. 或通过cPanel文件管理器

#### 步骤2：添加短代码函数

复制以下代码到主题的 `functions.php` 文件：

```php
<?php
// 共享充电宝ROI计算器短代码
function roi_calculator_shortcode($atts) {
    $atts = shortcode_atts(array(
        'width' => '100%',
        'height' => '1200',
    ), $atts);

    $calculator_url = get_template_directory_uri() . '/roi-calculator/index.html';

    return sprintf(
        '<div style="width: %s; max-width: 100%%; margin: 0 auto;">
            <iframe src="%s" width="100%%" height="%spx" frameborder="0"
                    style="border: none; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);"
                    title="ROI计算器"></iframe>
        </div>',
        esc_attr($atts['width']),
        esc_url($calculator_url),
        esc_attr($atts['height'])
    );
}
add_shortcode('roi_calculator', 'roi_calculator_shortcode');
?>
```

**如何编辑functions.php？**
1. `外观` → `主题文件编辑器`
2. 选择右侧的 `functions.php`
3. 在文件末尾添加上述代码
4. 点击 `更新文件`

#### 步骤3：使用短代码

在任何页面或文章中插入：
```
[roi_calculator]
```

自定义高度：
```
[roi_calculator height="1000"]
```

#### 步骤4：查看效果

保存并预览页面，您应该能看到完整的ROI计算器！

---

## 🎨 方法二：直接HTML嵌入

### 难度：⭐ (非常简单)
### 时间：2分钟

#### 适用场景
- 只需要在一个页面显示
- 不需要重复使用

#### 操作步骤

1. **上传index.html到可访问位置**（同方法一）

2. **在页面编辑器切换到"代码编辑器"模式**
   - Gutenberg编辑器：点击右上角三个点 → 代码编辑器
   - 经典编辑器：点击"文本"标签

3. **插入iframe代码：**
```html
<div style="width: 100%; max-width: 1200px; margin: 0 auto;">
    <iframe
        src="/wp-content/themes/你的主题名/roi-calculator/index.html"
        width="100%"
        height="1200px"
        frameborder="0"
        style="border: none; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);"
        title="ROI计算器">
    </iframe>
</div>
```

4. **发布页面**

---

## 🔗 方法三：使用外部链接

### 难度：⭐ (最简单)
### 时间：1分钟

#### 适用场景
- 计算器已部署到独立域名/子域名
- 如：https://calculator.yourdomain.com

#### 操作步骤

1. **创建链接按钮**

在页面中添加：
```html
<a href="https://calculator.yourdomain.com"
   target="_blank"
   style="display: inline-block;
          padding: 15px 40px;
          background: linear-gradient(135deg, #667EEA, #764BA2);
          color: white;
          text-decoration: none;
          border-radius: 10px;
          font-weight: 600;
          font-size: 18px;
          box-shadow: 0 5px 15px rgba(102,126,234,0.3);">
    💰 开始计算ROI
</a>
```

2. **或使用短代码**

添加到functions.php：
```php
function roi_button_shortcode($atts) {
    $atts = shortcode_atts(array(
        'url' => 'https://calculator.yourdomain.com',
        'text' => '开始计算ROI'
    ), $atts);

    return sprintf(
        '<a href="%s" target="_blank" style="display: inline-block; padding: 15px 40px; background: linear-gradient(135deg, #667EEA, #764BA2); color: white; text-decoration: none; border-radius: 10px; font-weight: 600;">%s</a>',
        esc_url($atts['url']),
        esc_html($atts['text'])
    );
}
add_shortcode('roi_button', 'roi_button_shortcode');
```

使用：
```
[roi_button url="https://calculator.yourdomain.com" text="立即计算"]
```

---

## 📦 方法四：安装WordPress插件

### 难度：⭐⭐ (简单)
### 时间：5分钟

#### 步骤1：下载插件

下载 `wordpress/powerbank-roi-calculator.zip`

#### 步骤2：上传安装

1. 登录WordPress后台
2. `插件` → `安装插件`
3. 点击 `上传插件`
4. 选择zip文件
5. 点击 `立即安装`
6. 激活插件

#### 步骤3：配置（可选）

`设置` → `ROI计算器` → 自定义颜色和参数

#### 步骤4：使用

```
[roi_calculator]
```

或在Gutenberg编辑器中搜索"ROI计算器"块

---

## 🎯 推荐方案对比

| 方案 | 推荐度 | 难度 | 时间 | 适用场景 |
|------|--------|------|------|----------|
| **iframe嵌入** | ⭐⭐⭐⭐⭐ | 最简单 | 5分钟 | 通用，推荐 |
| **直接HTML** | ⭐⭐⭐⭐ | 非常简单 | 2分钟 | 单页面 |
| **外部链接** | ⭐⭐⭐ | 最简单 | 1分钟 | 独立部署 |
| **WordPress插件** | ⭐⭐⭐⭐⭐ | 简单 | 5分钟 | 专业站点 |

**新手推荐**：iframe嵌入（方法一）
**快速测试**：直接HTML（方法二）
**独立部署**：外部链接（方法三）
**专业站点**：WordPress插件（方法四）

---

## ❓ 常见问题

### Q: 计算器不显示怎么办？

**检查清单：**
1. ✅ 文件路径是否正确？
2. ✅ 文件是否已成功上传？
3. ✅ 浏览器控制台有错误吗？

**测试方法：**
在浏览器直接访问：
```
https://你的网站.com/wp-content/themes/你的主题/roi-calculator/index.html
```

如果能看到计算器，说明文件路径正确。

### Q: 显示404错误？

**原因**：文件路径不对

**解决方案**：
1. 确认文件上传位置
2. 修改iframe的src路径
3. 使用完整URL：`https://你的网站.com/完整路径/index.html`

### Q: 样式显示异常？

**原因**：主题CSS冲突

**解决方案**：
使用iframe方式（方法一），样式完全隔离，不会冲突

### Q: 移动端显示不好？

**解决方案**：
调整iframe高度参数：
```
[roi_calculator height="800"]
```

或添加响应式CSS：
```css
@media (max-width: 768px) {
    iframe { min-height: 800px !important; }
}
```

### Q: 可以自定义颜色吗？

**可以！**

方式1：直接修改 index.html 中的颜色代码
```javascript
tailwind.config = {
    theme: {
        extend: {
            colors: {
                primary: '#YOUR_COLOR',
                secondary: '#YOUR_COLOR',
            }
        }
    }
}
```

方式2：使用插件的设置页面

### Q: 如何在Elementor中使用？

1. 添加 "HTML" 小工具
2. 粘贴iframe代码或短代码
3. 调整列宽度

### Q: 如何在Divi中使用？

1. 添加 "代码" 模块
2. 粘贴短代码：`[roi_calculator]`
3. 保存并查看

---

## 🆘 需要帮助？

### 详细文档
- [完整集成指南](INTEGRATION.md)
- [插件使用手册](powerbank-roi-calculator/README.md)
- [应用使用指南](../public/USAGE.md)

### 技术支持
- GitHub Issues: [提交问题](https://github.com/yourusername/repo/issues)
- 邮件: support@yourdomain.com

### 视频教程
- YouTube: [WordPress集成教程](https://youtube.com/...)（即将发布）
- B站: [WordPress插件安装](https://bilibili.com/...)（即将发布）

---

## ✅ 完成检查清单

安装完成后，检查以下项目：

- [ ] 计算器正常显示
- [ ] 参数可以输入和修改
- [ ] 计算结果正确显示
- [ ] 图表能正常渲染
- [ ] Excel导出功能正常
- [ ] 移动端显示正常
- [ ] 页面加载速度正常

全部完成？恭喜！🎉

---

**下一步**：阅读 [使用指南](../public/USAGE.md) 了解如何使用计算器的所有功能！
