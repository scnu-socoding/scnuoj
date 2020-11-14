<?php

use yii\bootstrap4\Nav;

/* @var $this \yii\web\View */
/* @var $content string */

$this->title = Yii::t('app', 'Wiki');;
?>

<?php $this->beginContent('@app/views/layouts/main.php'); ?>
<div class="row">
    <div class="col-md-4 col-lg-3">
        <?= Nav::widget([
            'items' => [
                ['label' => Yii::t('app', '判题信息'), 'url' => ['wiki/index']],
                ['label' => Yii::t('app', 'Contest'), 'url' => ['wiki/contest']],
                ['label' => Yii::t('app', '出题要求'), 'url' => ['wiki/problem']],
                ['label' => Yii::t('app', 'Special Judge'), 'url' => ['wiki/spj']],
                ['label' => Yii::t('app', 'OI 模式'), 'url' => ['wiki/oi']],
                ['label' => Yii::t('app', 'About'), 'url' => ['wiki/about']]
            ],
            'options' => ['class' => 'nav nav-pills flex-column']
        ]) ?>
    <p></p>
    </div>
    <div class="col-md-8 col-lg-9">
        <div class="wiki-contetn">
            <?= $content ?>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>

