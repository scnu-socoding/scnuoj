<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Solution;

/* @var $this yii\web\View */
/* @var $model app\modules\polygon\models\Problem */

$this->title = $model->title;
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Problems'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
$this->params['model'] = $model;

$model->setSamples();
?>
<div class="alert alert-light">
    <i class="fas fa-fw fa-info-circle"></i> 请在下面填写特判程序，具体可上网搜索 Testlib。
</div>

<div class="alert alert-light">
    <i class="fas fa-fw fa-info-circle"></i> 目前仅支持使用 C/C++ 编写特判程序。
</div>


<?php $form = ActiveForm::begin(); ?>



<?= $form->field($model, 'spj_source')->label(false)->widget('app\widgets\codemirror\CodeMirror'); ?>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-block']) ?>
</div>
<?php ActiveForm::end(); ?>