<?php

use yii\bootstrap4\Nav;

/* @var $this \yii\web\View */
/* @var $content string */

$this->title = Yii::t('app', 'Wiki');;
?>

<?php $this->beginContent('@app/views/layouts/main.php'); ?>

<?= Nav::widget([
            'items' => [
                [
                    'label' => Yii::t('app', '判题说明'), 'url' => ['wiki/index']
                ],
                [
                    'label' => Yii::t('app', '常见问题'), 'url' => ['wiki/faq']
                ],
                ['label' => Yii::t('app', 'About'), 'url' => ['wiki/about']],
                [
                    'label' => Yii::t('app', 'Contest'), 'url' => ['wiki/contest'],
                    'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()
                ],
                [
                    'label' => Yii::t('app', '出题要求'), 'url' => ['wiki/problem'],
                    'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()
                ],
                [
                    'label' => Yii::t('app', 'Special Judge'), 'url' => ['wiki/spj'],
                    'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()
                ],
                [
                    'label' => Yii::t('app', 'OI 模式'), 'url' => ['wiki/oi'],
                    'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()
                ]
            ],
            'options' => ['class' => 'nav nav-pills']
        ]) ?>
<p></p>
<div class="row">
    <div class="col animate__animated animate__fadeIn animate__faster">
        <?= $content ?>
    </div>
</div>
<?php $this->endContent(); ?>