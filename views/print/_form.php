<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ContestPrint */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="print-source-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'source')->textarea(['rows' => 20]) ?>

    <?php if (isset($model->contest->title)) : ?>
    <!-- 更新打印 -->
        <div class="alert alert-warning">
            请勿擅自编辑选手提交的代码，除非你知道这样做的后果是什么。一旦保存更改，将无法撤销更改。<p></p>
            <?= Html::a('返回打印列表', ['/print', 'id' => $model->contest_id], ['class' => 'btn btn-primary']); ?>
            <?= Html::a(Html::encode($model->contest->title), ['/contest/view', 'id' => $model->contest_id], ['class' => 'btn btn-primary']); ?>
            <?= Html::submitButton('我了解这样做的后果，继续保存代码', ['class' => 'btn btn-danger']) ?>
        </div>
    <?php else : ?>
    <!-- 创建打印 -->
        <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
    <?php endif; ?>
    <div class="form-group">

    </div>

    <?php ActiveForm::end(); ?>

</div>