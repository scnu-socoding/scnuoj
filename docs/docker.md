# 使用 Docker 部署 `scnuoj`

众所周知，`scnuoj` 性能垃圾，支持的功能少还难以配置。但是没办法，生活还是要继续，性能和功能想解决还得费点时间。那就先解决难以配置的问题吧。

## 1. 环境配置

### 1.1 安装 Git

```shell
#debian/ubuntu
sudo apt install git -y
#centos/rehl
sudo yum install git -y
```

### 1.2 安装 Docker

请参考[这篇教程](https://mirrors.tuna.tsinghua.edu.cn/help/docker-ce/)。

### 1.3 安装 docker-compose

```shell
#debian/ubuntu
sudo apt install docker-compose -y
#centos/rehl
sudo yum install docker-compose -y
```

至此，环境配置已经完成

## 2. 获取并修改源码

### 2.1 获取源码

```shell
git clone https://github.com/scnu-socoding/scnuoj.git
```

### 2.2 修改数据库信息

#### 2.2.1 修改 `/docker-compose.yaml`

将 `MYSQL_ROOT_PASSWORD` 的值更改为你想要的密码

#### 2.2.2 修改 `/config/db.php`

将 `dsn` 修改为 `mysql:host=mysql;dbname=scnuoj`

将 `username` 修改为 `root`

`password` 修改为 你刚才设置的密码

#### 2.2.3 修改 `/judge/config.ini`

将 `OJ_USE_PTRACE` 的值修改为 `0`

> Tips: 这里修改的原因是 P trace 机制和 Docker 存在兼容性问题导致。Docker 里的 system call 的值貌似不固定（?）

#### 2.2.4 修改 `/polygon/config.ini`

同上

#### 2.2.5 修改 `/conf.d/Caddyfile`

详情请根据 Caddy 官方文档。

## 3. 安装

可以选择本地打包或者直接拉取镜像。

### 本地打包

首次运行需要安装 `scnuoj` 。

先在 `/scnuoj` 目录下运行：

```shell
docker-compose up -d --build
```

生成镜像需要时间，请耐心等待打包完成。

### 拉取镜像

把 docker-compose.yaml 中的 build 改为对应的在线 image，然后运行

```shell
docker-compose up -d
```

运行成功后，进入 `php` 容器进行安装。

步骤如下：

> 首先，先使用 `docker container ls` 命令获取 `php` 容器的 `CONTAINER ID`。
>
> 然后，输入 `docker exec -it 刚才获取的ID sh` 进入容器。
>
> 运行 `./yii install` 进行安装。根据提示输入管理员账号、密码和邮箱即可。
>
> > 如果提示权限不足则先执行 `chmod +x yii` 。
>
> 输入 `exit` 退出容器。此时 `scnuoj` 已经搭建完成。

接下来输入:

```shell
docker-compose down; docker-compose up -d
```

重启容器，即可提供服务。

## 迁移

容器化最大的好处就是迁移的时候十分方便。迁移时只需要输入 `docker-compose down` 在源服务器上停止服务。将整个文件夹打包迁移到新服务器上，重复第一步的环境配置，即可通过 `docker-compose up -d` 一键开启服务。

## 判题机开启 oi 模式

进入判题机容器，kill 掉原有的判题机进程，然后输入

```shell
./judge/dispatcher -o
./polygon/polygon -o

```

即可开启 oi 模式。如需关闭，重启容器即可。

## 权限问题

如果出现权限问题，请在当前目录中运行

```shell
chown -R 1000:1000 *
```

## special judge 问题

如果出现迁移到 Docker 之后（非新装） special judge 无法运行正常判题，先参考上面的权限问题。如果还是无法解决，请进入 php 容器，进入 `/var/www/html/judge/data` 目录，运行

```shell
find . -type f -name "spj.cc" -exec sh -c '/usr/bin/g++ -fno-asm -std=c++14 -O2 {} -o $(dirname {})/spj -I /var/www/html/libraries' \;
```

重新编译所有题目的 special judge 。

## 安全性问题

由于关掉了 P trace 机制，可能会导致一些安全性问题。

建议对 judge 容器进行隔离，不要让其访问外部网络。使用 socket 连接的方式与数据库进行通信。

### 具体操作

在 `/judge/config.ini` 以及 `/polygon/config.ini` 中注释掉 `OJ_HOST_NAME` 和 `OJ_PORT_NUMBER` 两行，并解除 `OJ_MYSQL_UNIX_PORT` 的注释。

同时确保 `mysqld.sock` 已经映射到了 `judge` 容器中。

同时防止 `config.ini` 文件被读取，可以将其权限设置为 `root` 用户所有的 600 文件 `chmod 600 config.ini`。
