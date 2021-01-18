# SCNUOJ 安装指引

本文将指引你搭建 SCNUOJ。

如果你曾经部署过 JNOJ，那么部署 SCNUOJ 也是很容易的。

请注意：JNOJ 的一键部署脚本不适用于 SCNUOJ，所以请仔细阅读下面的内容。

## 环境准备

### LNMP 搭建

请先搭建标准 LNMP 环境：Linux + NGINX + MariaDB + PHP。

特别地：PHP 需要 7.4 或更高版本，如果你计划在旧版本的 Ubuntu 部署 SCNUOJ，可能需要添加第三方 PPA 升级 PHP。

由于判题机需要，你还需要安装 `libmysqlclient-dev`, `libmysql++-dev`，其它发行版也请安装对应的包。

### 获取 SCNUOJ

拉取代码仓库，执行：

```
$ git clone https://git.lug.ustc.edu.cn/bobby285271/scnuoj.git
```

获取项目所需的依赖，在 `scnuoj` 目录下执行：

```
$ composer install
```

## SCNUOJ 初始化

### 数据库配置

使用任意编辑器编辑 `scnuoj/config/db.php`：

```
<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yourdbname',
    'username' => 'yourusername',
    'password' => 'yourpassword',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    'enableSchemaCache' => !YII_DEBUG,
    'schemaCacheDuration' => 60,
    'schemaCache' => 'cache',
];
```

根据你的数据库配置替换 `yourdbname`, `yourusername`, `yourpassword` 为数据库名称、账户和密码。

### NGINX 配置

在 `/etc/nginx/sites-enabled/` 下创建配置文件：

```
server {
    listen 80;
    listen [::]:80;

    root /path/to/scnuoj/web;
    client_max_body_size 0;
    index index.php;
    server_name scnuoj;

    location / {
        try_files $uri $uri/ /index.php?$args;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
    }
}
```

重启 NGINX：

```
# nginx -t
# systemctl restart nginx
```

请根据你的需要修改端口、`scnuoj` 路径等信息，注意 `index.php` 入口文件在 `scnuoj/web` 中。

### Yii 安装

在 `scnuoj` 目录下执行：

```
$ ./yii install
```

此时根据你的 NGINX 配置，查看 SCNUOJ 是否已经可以访问。

如果无法访问，请检查 Composer 依赖是否成功安装、NGINX 配置是否正确。

如果可以访问但得到 Yii 的报错提示，请检查数据库、文件归属等是否正确。

### 公式渲染补丁

此步为可选项，你可能希望围观 [这个 Issue](https://github.com/shi-yang/jnoj/issues/102) 了解详情。

在 `scnuoj/scnuoj-patches` 目录下执行：

```
$ ./apply.sh
```

### 关闭站点调试

为了安全起见，如果你没有二次开发的需要，需要关闭 Yii 的调试功能。

编辑 `scnuoj/web/index.php`，注释下面的两行：

```
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
```

## 判题

### 判题用户

创建一个用于判题的用户，执行：

```
# useradd -m -u 1536 judge
```

### 主站点部署

编译判题机，在 `scnuoj/judge` 目录下执行：

```
# make
```

启动判题机，在同一目录下执行：

```
# ./dispatcher
```

如果需要启用 OI 模式，即希望遇到非正确测试点仍继续往下测试其它测试点，加上 `-o` 参数。

此时尝试在主题库提交代码，确认判题机工作情况。

随后尝试在管理员后台新建题目，确认测试点文件可以正常上传，如果无法上传则需检查 `scnuoj/judge/data` 目录归属。

### Polygon 部署

编译判题机，在 `scnuoj/polygon` 目录下执行：

```
# make
```

启动判题机，在同一目录下执行：

```
# ./polygon
```

此时尝试在 Polygon 提交代码，确认判题机工作情况。

随后尝试在 Polygon 新建题目，确认测试点文件可以正常上传，如果无法上传则需检查 `scnuoj/polygon/data` 目录归属。

## 下一步

由于 SCNUOJ 基于华南师大软院的实际情况做了一系列的修改，你可能需要阅读 [二次开发指南](./development.md)。