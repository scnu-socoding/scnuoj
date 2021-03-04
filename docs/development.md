# SCNUOJ 二次开发指引

对于大部分的需求，JNOJ（划掉）SCNUOJ 中基本都有现成的例子，老老实实搬砖就行。

## 目录结构

| 目录    | 说明 |
| ------- | ---- |
| `assets/` | 静态资源定义文件 |
| `commands/` |  控制台命令 |
| `components/` | Web 应用程序组件 |
| `config/` | Web 应用程序配置信息 |
| `controllers/` | 控制器 |
| `docs/` | 文档目录 |
| `judge/` | 判题机所在目录 |
| `judge/data` | 判题数据目录 |
| `libraries/` | SPJ 需要到的 Testlib 库 |
| `mail/` | 发邮件时的视图模板 |
| `messages/` | 多语言翻译 |
| `migrations/` | 数据库迁移时的各种代码 |
| `models/` | 业务模型文件 |
| `modules/admin` | 管理员后台应用 |
| `modules/polygon` | Polygon 出题系统 |
| `runtime/` | Web 应用程序运行时生成的缓存 |
| `scnuoj-patches` | 应用于 `vendor` 的补丁文件 |
| `tests/` | 各种测试 |
| `vendor/` | 第三方依赖 |
| `views/` | 视图文件 |
| `web/` |  Web 应用程序入口目录 |
| `widgets/` | 各种插件 |
| `socket.php` | 用于启动 Socket，提供消息通知功能 |

## Web 应用程序开发速成

Web 应用程序采用 PHP 语言 Yii 2 框架，MVC 模式（尚未有移植 Yii 3 的计划）。

实际上不需要学习 PHP 也不用学习 Yii 的，但是 MVC 还是要了解一下的。

 - **M** 指业务模型，在目录结构中的 `models/` 文件夹下。
 - **V** 指视图，在目录结构中的 `views/` 文件夹下。
 - **C** 指控制器，在目录结构中的 `controllers/` 文件夹下。


### 视图层

大多数情况下就是希望修改用户界面，只需在 `views` 文件夹下找到相关文件来修改。

对视图层作简单修改只需要一些前端基础，对 Bootstrap 4 有所了解，精通面向搜索引擎编程即可。

**第一个例子：修改主页的标题。**

感谢 `enablePrettyUrl` 感谢 JNOJ 开发组感谢我自己，在大部分时候根据 URL 对着找文件就行了。

首先找到 `views/site/index.php`，发现以下内容：

```php
<section class="py-5 text-center">
    <div class="row py-lg-5">
        <div class="mx-auto d-none d-md-block">
            <br />
            <h2>South China Normal University Online Judge</h2>
            <p class="lead text-muted"><?= Yii::$app->setting->get('schoolName') ?>在线评测系统</p>
        </div>
        <div class="mx-auto d-md-none">
            <br />
            <h2>SCNU Online Judge</h2>
            <p class="lead text-muted"><?= Yii::$app->setting->get('schoolName') ?>在线评测系统</p>
        </div>
    </div>
</section>
```

很显然是维护者在偷懒，没有在后台加相关的设置项，就结合 Bootstrap 4 的了解，知道宽屏和窄屏会显示不同的东西，接下来修改就是了。

**第二个例子：去除比赛页的 SCNUCPC 按钮。**

> 才不会告诉你这个按钮存在的意义就是写文档举例方便。

同样，找到 `views/contest/index.php`，但是一时间没有找到 SCNUCPC 相关的字眼。

但是把这个文件当普通的英文读，结合浏览器打开这个页面显示的东西，我们知道这个页面有两个部分，一个是搜索框一个是比赛列表。

然后你发现了这个东西：

```php
<?php echo $this->render('_search', ['model' => $searchModel]); ?>
```

很显然跟搜索有关，SCNUCPC 那个按钮正好跟搜索栏挨一块，然后找到一个 `views/contest/_search.php`，接下来问题就很简单了。

**第三个例子：修改顶部导航栏中 "问题" 左边的图标**

注意到每个页面都有一模一样的顶部导航栏，猜测会在 `views/layouts/` 里面，这个目录里面有几个文件，根据文件名望文生义即可。

接下来找到这样的内容，继续望文生义即可。

```php
$menuItemsLeft = [
    [
        'label' => '<i class="fas fa-fw fa-book-open"></i> ' . Yii::t('app', 'Problems'),
        'url' => ['/problem/index'],
        'active' => Yii::$app->controller->id == 'problem',
    ]
];
```

这里使用的是 Font Awesome 图标集，因为在同一个文件往上翻翻就会发现：

```
use app\assets\AppAsset;
AppAsset::register($this);
```

还是望文生义，发现确实有 `assets/AppAsset.php` 这个文件，这就是引入静态资源的方式了。

再往下就会探索到 `web/css` 和 `web/js` 两个目录了，这里不再介绍。

**接下来呢？**

你可能会用到 [yii2-bootstrap4 的文档](https://www.yiiframework.com/extension/yiisoft/yii2-bootstrap4/doc/guide/2.0/en/usage-widgets)，但是不用专门去啃这个文档，需要的时候自然就会知道看什么怎么看的了。

### 控制器与业务模型

那就是 `controllers` 和 `models` 两个目录了。

继续望文生义，公共题库相关的控制器就在 `controllers/ProblemController.php`，比赛相关的控制器就在 `controllers/ContestController.php`，以此类推。

打开控制器文件，发现都是 `action啥啥啥()` 这样的方法，即使没有学 Yii，知道钦定这个命名规则的不是 JNOJ 开发组就是 Yii，那就遵守这样的命名规则就好不会错的，后面遇到一些 `get啥啥啥()` 这样的方法也是一样的处理方式。

**第一个例子：添加 SCNUCPC 2021 榜单页。**

> 才不会告诉你 SCNUCPC 2020 这个页面就是拿来举例子用的。

应该不难找到 SCNUCPC 2020 的视图文件在哪里，照葫芦画瓢整亿个，保存到 `views/board/scnucpc2021.php`。

发现还是没法访问，那么就知道控制器的用途是啥了。打开 `controllers/BoardController.php`。

```php
<?php

namespace app\controllers;

use app\components\BaseController;

class BoardController extends BaseController
{
    public $layout = 'board';
    public function actionScnucpc2020()
    {
        return $this->render('scnucpc2020');
    }
}
```

这就是一个最简单的控制器了，发现有一个 `actionScnucpc2020()` 这样的方法。那就照葫芦画瓢整亿个：

```php
public function actionScnucpc2021()
{
    return $this->render('scnucpc2021');
}
```

既然是 Yii 钦定的命名规则，Yii 自然会把剩下的事情处理好，现在就可以访问新加的页面啦。

那么如果想要删掉这个页面呢，那就疯狂撤销就行了呀。

当然，有时这个方法的实现可谓是又臭又长，例如 `controllers/ContestController.php` 下有这样一个方法。

```php
public function actionIndex()
{
    $searchModel = new ContestSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    $this->layout = 'main';
    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]);
}
```

可能会完全不知道 `$dataProvider` 又是什么，这时就可以去视图文件看看哪里用到，知道是干啥的之后接下来就要到业务模型那里去找答案啦。

**第二个例子：更新榜单排名规则。**

榜单排名肯定是在榜单页显示的啦，你应该会很快找到 `views/contest/_standing_group.php` 和 `views/contest/_standing_oi.php` 两个视图文件，接下来又会在 `controllers/ContestController.php` 下找到一个 `actionStanding($id, $showStandingBeforeEnd = 1)` 的方法，然后发现有这样一句：

```php
$rankResult = $model->getRankData(true);
```

又可以开始望文生义大法了，知道这肯定就是在获取榜单数据了，接下来就去业务模型那里去找答案。直接在项目中搜索 `getRankData` 马上定位出来了，在 `models/Contest.php` 这里。

```php
public function getRankData($lock = true, $endtime = null)
{
    if ($this->type == Contest::TYPE_OI || $this->type == Contest::TYPE_IOI) {
        return $this->getOIRankData($lock, $endtime);
    }
    return $this->getICPCRankData($lock, $endtime);
}
```

马上就能知道有一个 `getOIRankData` 一个 `getICPCRankData`，我防出去了啊防出去以后自然是传统功夫点到为止（错乱）。

接下来就是一些码农大模拟啊，结构体排序这些东西了，这里不再多说。

**第三个例子：给比赛添加搜索。**

这个 SCNUOJ 是自带的，您当然不需要再实现一遍，不过也可以试着给 JNOJ 加一个。

我们现在假设你在看 JNOJ 的源码吧，JNOJ `controllers/ContestController.php` 的 `actionIndex()` 是这样的：

```php
public function actionIndex()
{
    $this->layout = 'main';
    $dataProvider = new ActiveDataProvider([
        'query' => Contest::find()->where([
            '<>', 'status', Contest::STATUS_HIDDEN
        ])->andWhere([
            'group_id' => 0
        ])->orderBy(['id' => SORT_DESC]),
    ]);

    return $this->render('index', [
        'dataProvider' => $dataProvider,
    ]);
}
```

`models/ContestSearch.php` 却是一片荒芜，好家伙。

此时你比对一下 `models/ProblemSearch.php`，就发现了可以照葫芦画瓢，顺便整理一下代码。

于是直接把上面的代码挪进去，加上一行查一下 title 就行了。

```php
$query->FilterWhere(['like', 'title', $this->title])
    ->andwhere([
        '<>', 'status', Contest::STATUS_HIDDEN
    ])->andWhere([
        'group_id' => 0
    ])->orderBy(['id' => SORT_DESC]);
```

当然还有一些复杂一些的例子，直接在项目目录搜索 `new Query()` 和 `Yii::$app->db->createCommand()` 就行了。

例如如何给做题量排行添加学号呢？当然 JNOJ 还是没有：

```php
$query = (new Query())->select('u.id, u.nickname, u.rating, s.solved')
    ->from('{{%user}} AS u')
    ->innerJoin('(SELECT COUNT(DISTINCT problem_id) AS solved, created_by FROM {{%solution}} WHERE result=4 AND status=1 GROUP BY created_by ORDER BY solved DESC) as s', 'u.id=s.created_by')
    ->orderBy('solved DESC, id');
```

这时就搜上面两个关键词找一下，很快就会知道 Join 是什么东西了，然后就可以对比一下 `controllers/RatingController.php` 现在的实现。

**接下来呢？**

加了功能当然是给我们发 PR 啊（逃）。

## 判题机调参速成

这里就讲讲如何玄学调参，所有例子都基于主题库判题机，Polygon 的同理。

**第一个例子：修改编译参数。**

发现有这样一个文件 `judge/src/language.h`，上面的内容跟编译参数贼像，就是他了。

**第二个例子：系统调用。**

当你遇到本地 AC 提交 RE 一定是判题机出现了问题（大雾），这时候就看看检查日志里面是哪个系统调用号，往 `judge/src/okcalls64.h` 加上就行了。当然你可能会有点强迫症，不希望这个文件上一大串不知道是啥的数字，这时候就去 `/usr/include/x86_64-linux-gnu/asm/unistd_64.h` 查一下这个数字，然后再去 `/usr/include/x86_64-linux-gnu/bits/syscall.h` 查一下相应的 define。

当然系统调用也不是随便加的。例如人家 `system("rm -rf /");` 被 RE 那是应该的，这里推荐关注 HUSTOJ 的系统调用设置。

**第三个例子：记录 AC 测试点数据。**

你会发现 AC 了的测试点不会显示测试点数据，而且 Web 应用程序也没有方法调，那就可以猜到是判题机的问题了，很快啊你就能找到这样一个函数：

```c
void record_data(problem_struct problem,
                 verdict_struct * verdict_res,
                 char * infile, char * outfile, char * userfile);
```

好家伙，测试数据为啥被截断的原因也顺便找到了，那就不用举第四个例子了。

接下来就看看哪里调用了这个函数：

```c
if (run_result == OJ_AC) {
    pass_count++;
} else {
    // 记录该数据点的运行信息
    record_data(problem, &verdict_res, infile, outfile, userfile);
}
```

完结撒花！