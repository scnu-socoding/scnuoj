<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Problem */

$this->title = Yii::t('app', 'Create Problem');
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Problems'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="problem-create">
    <p class="lead">创建一道题目，不借助 Polygon 系统。</p>
    <div class="alert alert-light">
        <i class="fas fa-fw fa-info-circle"></i> 感谢您参与 <?= Yii::$app->setting->get('ojName') ?> 公共题库的建设！创建题目前，请先阅读 <?= Html::a('帮助文档', ['/wiki/problem'], ['target' => '_blank']) ?>。
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>