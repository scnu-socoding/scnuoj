<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\modules\polygon\models\Problem */

$this->title = Yii::t('app', 'Create Problem');
?>
<div class="problem-create">

    <p class="lead">创建一道题目。</p>

    <div class="alert alert-info">
        <i class="fas fa-fw fa-info-circle"></i> 欢迎使用 Polygon 系统，在此处上传题目即代表你同意管理员同步你的题目到公共题库供其他用户提交。
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>