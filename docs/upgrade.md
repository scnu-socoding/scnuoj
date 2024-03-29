# SCNUOJ 升级指引

可以从管理员后台或是 [`CHANGELOG.md`](../CHANGELOG.md) 文件中查看目前的版本更新情况。

## 从 JNOJ 或 SCNUOJ 2020.x 升级

### 警告

**我们不为此类升级提供支持。**

SCNUOJ 2021.x 相比 JNOJ 和 SCNUOJ 2020.x **至少**有以下的**破坏性变化**：

* VIP 角色被修改用于助教角色，原 VIP 用户将获得进入后台管理题目的权限。
* 私有题目类型已经不再被支持，如果存在相关题目可能会报错。
* 移除了个人排位赛的支持，如果已经存在相应赛制的比赛将会报错。
* 重新实现了打星支持，与原有实现不兼容，如果已经存在线下比赛，排名数据将会更新。
* 重写了 OI 赛制和 IOI 赛制的排名规则，如果已经存在 OI/IOI 比赛，排名数据将会更新。
* 部分页面的永久链接发生变化，涉及小组、个人设置等页面。
* 移除了线下赛模式的支持，如果已经存在线下赛可能会报错。

**在升级开始前，请先确认你的 JNOJ 已经更新到 [`67a9d4106d`](https://github.com/shi-yang/jnoj/tree/67a9d4106dee62727e840ee9318f6ddd45daab84) 或更高版本，且环境符合 SCNUOJ 部署的要求。随后请根据上述内容，修改用户、题目、比赛等设置。**

### 执行升级

请不要尝试原地升级。根据 [安装指引](./installation.md) 从零开始部署 SCNUOJ，配置数据库时直接使用原数据库。

接下来结束 JNOJ 的判题机进程，迁移题目数据：

```
# cp -rpf /path/to/jnoj/judge/data/. /path/to/scnuoj/judge/data
# cp -rpf /path/to/jnoj/polygon/data/. /path/to/scnuoj/polygon/data
```

将 `/path/to/jnoj` 和 `/path/to/scnuoj` 替换为正确的路径。

随后根据 [安装指引](./installation.md) 或下面 "从旧版 SCNUOJ 升级" 一节编译并启动 SCNUOJ 的判题机。

如果你在使用 JNOJ 时曾经使用 Editor.md 上传过图片，你还需要迁移这些资源：

```
# cp -rpf /path/to/jnoj/web/uploads/. /path/to/scnuoj/web/uploads
```

## 从 SCNUOJ 2021.x 升级

在 `scnuoj` 目录下执行以下命令。

首先拉取最新代码。如果你做了二次开发，你可能需要自行处理相关的冲突：

```
$ git pull
```

更新 Composer 依赖：

```
$ composer install
```

更新数据库的变化情况：

```
$ ./yii migrate
```

重新编译并启动主题库判题机：

```
# cd judge
# pkill -9 dispatcher
# make
# ./dispatcher
# cd ..
```

重新编译并启动 Polygon 判题机：

```
# cd polygon
# pkill -9 polygon
# make
# ./polygon
# cd ..
```

如果你之前应用了 `scnuoj-patches` 中的补丁，你可能需要重新应用。

最后你可能希望清除 Web 应用程序的缓存文件，在 `scnuoj/runtime` 和 `scnuoj/web/assets` 下分别执行：

```
# rm -rf *
```
