<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Problem */

$this->title = Yii::t('app', 'Import Problem');
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Problems'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
$maxFileSize = min(ini_get("upload_max_filesize"), ini_get("post_max_size"));
?>
<div class="problem-import">

    <p class="lead">从 HUSTOJ 导入题目到公共题库。</p>

    <div class="alert alert-light">
        <i class="fas fa-fw fa-info-circle"></i> 感谢您参与 <?= Yii::$app->setting->get('ojName') ?> 公共题库的建设！本功能未经测试，请谨慎使用。
    </div>



    <?php if (extension_loaded('xml')) : ?>

        <div class="alert alert-light">
            <i class="fas fa-fw fa-info-circle"></i> 提交文件为 ZIP 或者 XML 格式，根据您的 PHP 设置，上传的文件无法大于 <?= $maxFileSize ?>。
        </div>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'target' => '_blank']]) ?>

        <?= $form->field($model, 'problemFile', ['options' => ['class' => 'custom-file'], 'template' => '{label}{input}'])->fileInput(
            ['class' => 'custom-file-input']
        )->label(true, ['class' => 'custom-file-label', 'id' => 'myfile']) ?>
        <p></p>

        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-success btn-block']) ?>

        <?php ActiveForm::end() ?>
    <?php else : ?>
        <div class="alert alert-light">
            <i class="fas fa-fw fa-info-circle"></i> 服务器尚未开启 <code>php-xml</code> 扩展，请安装 <code>php-xml</code> 后再使用此功能。
        </div>
    <?php endif; ?>
</div>
<?php
$js = <<<EOF
$("#myfile").html("选择一个文件");

$("#uploadform-problemfile").on("change", function () {
    $("#myfile").html($(this).get(0).files[0].name);
});
EOF;
$this->registerJs($js);
?>