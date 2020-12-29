<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Contest;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

/* @var $this yii\web\View */
/* @var $model app\models\Contest */

$this->title = $model->title;
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contest'), 'url' => ['/contest/index']];
// $this->params['breadcrumbs'][] = $this->title;
$this->params['model'] = $model;
?>
<?php if ($model->status == Contest::STATUS_PRIVATE): ?>
    <div class="card bg-secondary text-white">
        <div class="card-body">
            <h3>私密比赛</h3>
        </div>
    </div>
    <p></p>
    <div class="card">
        <div class="card-body">
            该比赛仅参赛人员可见。
        </div>
    </div>
    <?php
            $this->title = '私密比赛';
            $this->params['model']->title = '';
            $this->params['model']->start_time = '';
            $this->params['model']->end_time = '';
        ?>
<?php else: ?>

    <?php
                $menuItems = [
                    [
                        'label' => '<span class="glyphicon glyphicon-home"></span> ' . Yii::t('app', 'Information'),
                        'url' => ['contest/view', 'id' => $model->id],
                        'linkOptions' => ['class' => 'text-dark active']
                    ],
                    [
                        'label' => '<span class="glyphicon glyphicon-glass"></span> ' . Yii::t('app', 'Standing'),
                        'url' => Url::toRoute(['/contest/standing2', 'id' => $model->id]),
                        'linkOptions' => ['class' => 'text-dark'],
                        'visible' => $model->getRunStatus() != Contest::STATUS_NOT_START
                    ]
                ];
                echo Nav::widget([
                    'items' => $menuItems,
                    'options' => ['class' => 'nav nav-tabs hidden-print', 'style' => 'margin-bottom: 15px'],
                    'encodeLabels' => false
                ]) ?> 

    <div class="card bg-secondary text-white">
        <div class="card-body">
            <h3><?= $this->title ?></h3>
        </div>
    </div>
    <p></p>
    <div class="card">
        <div class="card-body">
            您尚未报名参加该比赛，请先参赛，或比赛结束后再来访问。
        </div>
    </div>
    <p></p>
    <?php if ($model->scenario == Contest::SCENARIO_OFFLINE): ?>
        <div class="card">
            <div class="card-body">
            该比赛为线下赛，如需参赛，请联系管理员。
            </div>
        </div>
        <p></p>
    <?php else: ?>
        
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">参赛协议</h3>
                <p>一、遵守比赛规则，不与其他人分享解决方案；</p>
                <p>二、不以任何形式破坏和攻击测评系统。</p>
            </div>
        </div>

        <p></p>

        <?= Html::a(Yii::t('app', 'Agree above and register'), ['/contest/register', 'id' => $model->id, 'register' => 1], ['class' => 'btn btn-block btn-outline-secondary']) ?>
    <?php endif; ?>
<?php endif; ?>