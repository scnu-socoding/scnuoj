<div class="d-none d-sm-block">
    <img src="<?= Yii::getAlias('@web') . '/images/error-header.jpg' ?>" class="img-fluid rounded">
    <p></p>
</div>
<div class="list-group">

    <div class="list-group-item">
        <b>名称</b>
        <span class="float-right text-secondary">
            <?=  Yii::$app->setting->get('schoolName') ?>在线评测系统
        </span>
    </div>
    <div class="list-group-item">
        <b>SCNUOJ 版本</b>
        <span class="float-right text-secondary">
            Version <?= date("Y.m.d", filemtime(Yii::getAlias('@app/CHANGELOG.md'))) ?>
        </span>
    </div>
    <a class="list-group-item list-group-item-action" target="_blank" href="//github.com/SCNU-SoCoding/scnuoj">
        <b>项目网址</b>
        <span class="float-right text-secondary">
            <i class="fas fa-fw fa-angle-right"></i>
        </span>
    </a>
    <a class="list-group-item list-group-item-action" target="_blank" href="//github.com/SCNU-SoCoding/scnuoj/issues">
        <b>问题反馈</b>
        <span class="float-right text-secondary">
            <i class="fas fa-fw fa-angle-right"></i>
        </span>
    </a>
    <a class="list-group-item list-group-item-action" target="_blank"
        href="//github.com/SCNU-SoCoding/scnuoj/graphs/contributors">
        <b>贡献者名单</b>
        <span class="float-right text-secondary">
            <i class="fas fa-fw fa-angle-right"></i>
        </span>
    </a>
</div>

<p></p>
<div class="list-group">
    <div class="text-right text-secondary list-group-item">
        SCNUOJ 的诞生离不开 JNOJ，在此特别鸣谢 JNOJ 开发组
    </div>
</div>