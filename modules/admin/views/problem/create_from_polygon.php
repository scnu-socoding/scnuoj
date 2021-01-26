<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Problem */

$this->title = Yii::t('app', 'Import Problem From Polygon System');
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Problems'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="problem-create">

    <p class="lead">从 Polygon 题库同步题目到公共题库。</p>

    <div class="alert alert-light">
        <i class="fas fa-fw fa-info-circle"></i> 感谢您参与 <?= Yii::$app->setting->get('ojName') ?> 公共题库的建设！下面两栏请任选一项填写，重复同步同一题目仅做强制覆盖不会另外新建题目。
    </div>

    <?= Html::beginForm() ?>
    <div class="form-group">
        <div class="alert alert-light">
            <i class="fas fa-fw fa-info-circle"></i> 单个导入，请提供位于 <?= Html::a(Yii::t('app', 'Polygon System'), ['/polygon/problem']) ?> 问题对应编号。
        </div>

        <div class="input-group">
            <div class="input-group-prepend" id="polygon_problem_id"><span class="input-group-text">编号</span></div>
            <?= Html::textInput('polygon_problem_id', '', ['class' => 'form-control']) ?>
        </div>
    </div>

    <div class="form-group">
    <div class="alert alert-light">
            <i class="fas fa-fw fa-info-circle"></i> 批量导入，请提供位于 <?= Html::a(Yii::t('app', 'Polygon System'), ['/polygon/problem']) ?> 问题对应编号的范围。
        </div>

        <div class="input-group">
            <div class="input-group-prepend" id="polygon_problem_id"><span class="input-group-text">起始编号</span></div>
            <?= Html::textInput('polygon_problem_id_from', '', ['class' => 'form-control']) ?>
        </div>
        <p></p>

        <div class="input-group">
            <div class="input-group-prepend" id="polygon_problem_id"><span class="input-group-text">结束编号</span></div>
            <?= Html::textInput('polygon_problem_id_to', '', ['class' => 'form-control']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-success btn-block']) ?>
    </div>
    <?= Html::endForm() ?>
</div>