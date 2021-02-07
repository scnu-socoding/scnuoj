<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Solution;

/* @var $this yii\web\View */
/* @var $model app\modules\polygon\models\Problem */

$this->title = $model->title;
// $this->params['breadcrumbs'][]][] = ['label' => Yii::t('app', 'Problems'), 'url' => ['index']];
// $this->params['breadcrumbs'][]][] = $this->title;
$this->params['model'] = $model;

$model->setSamples();
?>

<div class="alert alert-light">
    <i class="fas fa-fw fa-info-circle"></i> 请在此页面提供一个标程，即解答该问题的正确代码程序。标程将被用来生成测试数据的标准输出。
</div>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'solution_lang', [
        'template' => "{input}",
    ])->dropDownList(Solution::getLanguageList(), ['class' => 'form-control custom-select selectpicker']) ?>

<?= $form->field($model, 'solution_source', [
        'template' => "{input}",
    ])->widget('app\widgets\codemirror\CodeMirror'); ?>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-block']) ?>
</div>
<?php ActiveForm::end(); ?>