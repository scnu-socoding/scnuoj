<?php

use yii\bootstrap4\Nav;

/* @var $this \yii\web\View */
/* @var $content string */

$this->title = Yii::t('app', 'Wiki');;
?>

<?php $this->beginContent('@app/views/layouts/main.php'); ?>

<?= Nav::widget([
            'items' => [
                ['label' => Yii::t('app', '判题'), 'url' => ['wiki/index']],
                ['label' => Yii::t('app', 'Contest'), 'url' => ['wiki/contest']],
                // ['label' => Yii::t('app', '出题要求'), 'url' => ['wiki/problem']],
                // ['label' => Yii::t('app', 'Special Judge'), 'url' => ['wiki/spj']],
                // ['label' => Yii::t('app', 'OI 模式'), 'url' => ['wiki/oi']],
                ['label' => Yii::t('app', 'About'), 'url' => ['wiki/about']]
            ],
            'options' => ['class' => 'nav nav-pills']
        ]) ?>
<p></p>
<div class="row">
    <div class="col">
        <?= $content ?>
    </div>
</div>
<?php $this->endContent(); ?>