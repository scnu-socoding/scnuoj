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

`password` 修改为 你刚才设置的密码

#### 2.2.3 修改 `/judge/src/judge.c`

将 `use_ptrace` 的值修改为 `0`

> Tips: 这里修改的原因是 P trace 机制和 Docker 存在兼容性问题导致。Docker 里的 system call 的值貌似不固定（?）

#### 2.2.4 修改 `/polygon/src/judge.c`

同上

#### 2.2.5 修改 `/conf.d/Caddyfile`

详情请根据 Caddy 官方文档。

## 3. 安装

首次运行需要安装 `scnuoj` 。

先在 `/scnuoj` 目录下运行：

```shell
docker-compose up -d --build
```

生成镜像需要时间，请耐心等待打包完成。

运行成功后，进入 `php` 容器。

首先，先使用 `docker container ls` 命令获取 `php` 容器的 `CONTAINER ID`。

然后，输入 `docker exec -it 刚才获取的ID sh` 进入容器。

运行 `./yii install` 进行安装。根据提示输入管理员账号、密码和邮箱即可。

> 如果提示权限不足则先执行 `chmod +x yii` 。

按住 `ctrl+c` 退出容器。此时 `scnuoj` 已经搭建完成。

输入:

```shell
docker-compose down; docker-compose up -d
```

重启容器，即可提供服务。

## 迁移

容器化最大的好处就是迁移的时候十分方便。迁移时只需要输入 `docker-compose down` 在源服务器上停止服务。将整个文件夹打包迁移到新服务器上，重复第一步的环境配置，即可通过 `docker-compose up -d` 一键开启服务。
