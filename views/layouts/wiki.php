<?php

use yii\bootstrap\Nav;

/* @var $this \yii\web\View */
/* @var $content string */

$this->title = 'Wiki';
?>

<?php $this->beginContent('@app/views/layouts/main.php'); ?>
<div class="row">
    <div class="col-md-3">
        <?= Nav::widget([
            'items' => [
                ['label' => Yii::t('app', '判题信息'), 'url' => ['wiki/index']],
                ['label' => Yii::t('app', 'Contest'), 'url' => ['wiki/contest']],
                ['label' => Yii::t('app', '出题要求'), 'url' => ['wiki/problem']],
                ['label' => Yii::t('app', 'Special Judge'), 'url' => ['wiki/spj']],
                ['label' => Yii::t('app', 'OI 模式'), 'url' => ['wiki/oi']],
                ['label' => Yii::t('app', 'About'), 'url' => ['wiki/about']]
            ],
            'options' => ['class' => 'nav nav-pills nav-stacked']
        ]) ?>
    </div>
    <div class="col-md-9">
        <div class="wiki-contetn">
            <?= $content ?>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>

