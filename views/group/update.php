<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Group */

$this->title = $model->name;
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Groups'), 'url' => Yii::$app->user->isGuest ? ['/group/index'] : ['/group/my-group']];
// $this->params['breadcrumbs'][] = $this->title;

?>

<h3><?= Html::encode($this->title) ?></h3>
<div class="group-update">

    <p></p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <hr>

    <?= Html::a('删除该小组', ['/group/delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data-confirm' => '此操作会把该小组的比赛信息及提交记录全部删除，且不可恢复，你确定要删除吗？',
        'data-method' => 'post',
    ]) ?>

</div>