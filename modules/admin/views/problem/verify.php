<?php

use yii\helpers\Html;
use app\models\Solution;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Modal;

/* @var $this yii\web\View */
/* @var $solutions array */
/* @var $model app\models\Problem */
/* @var $newSolution app\models\Solution */

$this->title = $model->title;
$this->params['model'] = $model;
$loadingImgUrl = Yii::getAlias('@web/images/loading.gif');
?>
<div class="solutions-view">
    <div class="alert alert-light">
        <i class="fas fa-fw fa-info-circle"></i> 题目的验题状态将不会在前台展示．不会出现泄题情况。
    </div>
    <?php if (!empty($solutions)) : ?>
        <div class="table-responsive solution-index">
            <table class="table">
                <thead>
                    <tr>
                        <th width="60px">运行 ID</th>
                        <th width="100px">测评结果</th>
                        <th width="60px">语言</th>
                        <th width="70px">时间</th>
                        <th width="80px">内存</th>
                        <th width="80px">代码长度</th>
                        <th width="60px">提交时间</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($solutions as $solution) : ?>
                        <tr>
                            <td><?= Html::a(
                                    $solution['id'],
                                    ['/solution/source', 'id' => $solution['id']],
                                    ['onclick' => 'return false', 'data-click' => "solution_info"]
                                )  ?></td>
                            <td>
                                <?php
                                if ($solution['result'] <= Solution::OJ_WAITING_STATUS) {
                                    $waitingHtmlDom = 'waiting="true"';
                                    $loadingImg = "<img src=\"{$loadingImgUrl}\">";
                                } else {
                                    $waitingHtmlDom = 'waiting="false"';
                                    $loadingImg = "";
                                }
                                $innerHtml =  'data-verdict="' . $solution['result'] . '" data-submissionid="' . $solution['id'] . '" ' . $waitingHtmlDom;
                                if ($solution['result'] == Solution::OJ_AC) {
                                    $span = '<strong class="text-success"' . $innerHtml . '>' . Solution::getResultList($solution['result']) . '</strong>';
                                } else {
                                    $span = '<strong class="text-danger" ' . $innerHtml . '>' . Solution::getResultList($solution['result']) . $loadingImg . '</strong>';
                                }
                                echo $span;
                                ?>
                            </td>
                            <td>
                                <?= Solution::getLanguageLiteList($solution['language']) ?>
                            </td>
                            <td>
                                <?= $solution['time'] ?> MS
                            </td>
                            <td>
                                <?= $solution['memory'] ?> KB
                            </td>
                            <td>
                                <?= $solution['code_length'] ?>
                            </td>
                            <td><?= Yii::$app->formatter->asRelativeTime($solution['created_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($newSolution, 'language', [
        'template' => "{input}",
    ])->dropDownList($newSolution::getLanguageList(), ['class' => 'form-control custom-select selectpicker']) ?>

    <?= $form->field($newSolution, 'source', [
        'template' => "{input}",
    ])->widget('app\widgets\codemirror\CodeMirror'); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-success btn-block']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php Modal::begin([
    'title' => '查看提交',
    'size' => Modal::SIZE_LARGE,
    'options' => ['id' => 'solution-info']
]); ?>
<div id="solution-content">
</div>
<?php Modal::end(); ?>
<?php
$js = <<<EOF

$('[data-click=solution_info]').click(function() {
    $.ajax({
        url: $(this).attr('href'),
        type:'post',
        error: function(){alert('error');},
        success:function(html){
            $('#solution-content').html(html);
            $('#solution-info').modal('show');
        }   
    });
});
EOF;
$this->registerJs($js);
?>