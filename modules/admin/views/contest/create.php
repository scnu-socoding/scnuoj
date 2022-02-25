<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Contest */

$this->title = Yii::t('app', 'Create Contest');
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contests'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;

$model->status = $model::STATUS_HIDDEN;
$model->type = $model::TYPE_RANK_GROUP;
$model->scenario = $model::SCENARIO_ONLINE;
$model->enable_clarify = 1;
$model->enable_board = 1;
$model->enable_print = 0;
$model->punish_time = 20; //罚时初始值
?>
<div class="contest-create">

    <p class="lead">创建一个新的公共比赛或题目集。</p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
