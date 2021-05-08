<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\polygon\models\Problem */

$this->title = Html::encode($model->title);
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Problems'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = Yii::t('app', 'Update');
$this->params['model'] = $model;
?>
<div class="problem-update">

    <div class="alert alert-info">
        <i class="fas fa-fw fa-info-circle"></i> 如果你对题面进行了修改并希望管理员同步到主题库，请在题目标题一栏标明以方便管理员及时处理。
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>