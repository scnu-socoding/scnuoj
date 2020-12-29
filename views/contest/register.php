<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Contest */

$this->title = $model->title;
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contest'), 'url' => ['/contest/index']];
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="card bg-secondary text-white">
    <div class="card-body">
        <h3><?= Html::encode($model->title)?></h3>
    </div>
</div>
<p></p>

<div class="card">
    <div class="card-body">
        <h3 class="card-title">参赛协议</h3>
        <p>一、遵守比赛规则，不与其他人分享解决方案；</p>
        <p>二、不以任何形式破坏和攻击测评系统。</p>
    </div>
</div>

<p></p>

<?= Html::a(Yii::t('app', 'Agree above and register'), ['/contest/register', 'id' => $model->id, 'register' => 1], ['class' => 'btn btn-block btn-outline-secondary']) ?>