<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

/* @var $model app\models\Contest */

$this->title = $model->title;
?>


<?php
    $menuItems = [
        [
            'label' => '<span class="glyphicon glyphicon-home"></span> ' . Yii::t('app', 'Information'),
            'url' => ['contest/view', 'id' => $model->id],
            'linkOptions' => ['class' => 'text-dark']
        ],
        [
            'label' => '<span class="glyphicon glyphicon-glass"></span> ' . Yii::t('app', 'Standing'),
            'url' => Url::toRoute(['/contest/standing2', 'id' => $model->id]),
            'linkOptions' => ['class' => 'text-dark active'],
            // 'visible' => $model->getRunStatus() != Contest::STATUS_NOT_START
        ]
    ];
    echo Nav::widget([
        'items' => $menuItems,
        'options' => ['class' => 'nav nav-tabs hidden-print', 'style' => 'margin-bottom: 15px'],
         'encodeLabels' => false
]) ?>
<?php echo $this->render('standing', [
    'model' => $model,
    'rankResult' => $rankResult,
    'showStandingBeforeEnd' => $showStandingBeforeEnd
]); ?>