<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GroupSearch */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    'options' => [
        'class' => ''
    ],
]); ?>
<div class="row">


    <div class="col-lg-10" style="margin-bottom: 1rem;">
        <?= $form->field($model, 'name', [
            'template' => "<div class=\"input-group\">{input}</div>",
            'options' => ['class' => ''],
        ])->textInput(['maxlength' => 128, 'autocomplete' => 'off', 'placeholder' => Yii::t('app', 'Title')])->label(false) ?>

    </div>

    <div class="col-lg-2" style="margin-bottom: 1rem;">
        <div class="btn-group btn-block search-submit">
            <?= Html::submitButton('<i class="fas fa-fw fa-search"></i> ' . Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>