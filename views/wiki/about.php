<div class="d-none d-sm-block">
    <img src="<?= Yii::getAlias('@web') . '/images/about-scnuoj.jpg' ?>" class="img-fluid rounded">
    <p></p>
</div>

<div class="alert alert-light">
    <i class="fas fa-fw fa-info-circle"></i> <b>SCNUOJ</b> 可对用户在线提交的源代码进行编译和执行，并通过预先设计的测试数据检验代码的正确性。
</div>
<p></p>
<div class="list-group">

    <div class="list-group-item">
        名称
        <span class="float-right text-secondary">
            <?= Yii::$app->setting->get('schoolName') ?>在线评测系统
        </span>
    </div>
    <div class="list-group-item">
        SCNUOJ 版本
        <span class="float-right text-secondary">
            <?= file_get_contents(Yii::getAlias('@app/VERSION')) ?>
        </span>
    </div>
</div>

<p></p>
<div class="list-group">
    <a class="list-group-item list-group-item-action" target="_blank" href="//github.com/SCNU-SoCoding/scnuoj">
        项目源码
        <span class="float-right text-secondary">
            <i class="fas fa-fw fa-angle-right"></i>
        </span>
    </a>
    <a class="list-group-item list-group-item-action" target="_blank" href="//github.com/SCNU-SoCoding/scnuoj/issues">
        问题反馈
        <span class="float-right text-secondary">
            <i class="fas fa-fw fa-angle-right"></i>
        </span>
    </a>
    <a class="list-group-item list-group-item-action" target="_blank" href="//github.com/SCNU-SoCoding/scnuoj/graphs/contributors">
        贡献者名单
        <span class="float-right text-secondary">
            <i class="fas fa-fw fa-angle-right"></i>
        </span>
    </a>
</div>
