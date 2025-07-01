Alfred-codezm-workflows-timestamp-convert
=========================================

## 时间戳转换工具
默认快捷键`t`，查看当前时间格式展示。

### 效果

!["Alfred-codezm-workflows-timestamp-convert Demo"](demo.gif)

### 下载

[点击下载](https://github.com/codezm/Alfred-codezm-workflows-timestamp-convert/releases/download/v3.0.0/Alfred-codezm-workflows-timestamp-convert.alfredworkflow)

### 安装

下载后直接双击导入即可.

### 使用
> 支持 PHP 与 Python 脚本，默认 Python 脚本。切换方式：修改 SCRIPT_PATH 变量。
> 示例： 
> PHP 脚本：/usr/bin/php timestamp.php

- 默认展示当天时间信息.
- 你也可以使用 `t tomorrow` `t yesterday`, 更多格式[参见](https://www.php.net/manual/en/function.strtotime.php). **PHP 独有**
- 将时间戳转换成日期格式, 反之亦然 `t 1495276608` `t 2017-05-20 18:52:46`.
- 选中某一项转换结果键入 `Enter` 即可复制, `Shift + Enter` 将发音.
