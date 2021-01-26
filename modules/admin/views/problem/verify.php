<?php

use yii\helpers\Html;
use app\models\Solution;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $solutions array */
/* @var $model app\models\Problem */
/* @var $newSolution app\models\Solution */

$this->title = $model->title;
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Problems'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
$this->params['model'] = $model;
$loadingImgUrl = Yii::getAlias('@web/images/loading.gif');
?>
<div class="solutions-view">
    <h1>
        <?= Html::encode($model->title) ?>
    </h1>
    <p class="text-muted">提示：题目的验题状态将不会在前台展示．不会出现泄题情况</p>
    <div class="table-responsive">
        <table class="table table-bordered table-rank">
            <thead>
                <tr>
                    <th width="60px">Run ID</th>
                    <th width="60px">Submited Time</th>
                    <th width="100px">Result</th>
                    <th width="60px">Language</th>
                    <th width="70px">Time</th>
                    <th width="80px">Memory</th>
                    <th width="80px">Code Length</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($solutions as $solution) : ?>
                    <tr>
                        <th><?= $solution['id'] ?></th>
                        <th><?= $solution['created_at'] ?></th>
                        <th>
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
                                echo Html::a(
                                    $span,
                                    ['/solution/source', 'id' => $solution['id']],
                                    ['onclick' => 'return false', 'data-click' => "solution_info", 'data-pjax' => 0]
                                );
                            } else {
                                echo '<strong class="text-danger" ' . $innerHtml . '>' . Solution::getResultList($solution['result']) . $loadingImg . '</strong>';
                            }
                            ?>
                        </th>
                        <th>
                            <?= Html::a(Solution::getLanguageList($solution['language']), ['/solution/detail', 'id' => $solution['id']], ['target' => '_blank']) ?>
                        </th>
                        <th>
                            <?= $solution['time'] ?>
                        </th>
                        <th>
                            <?= $solution['memory'] ?>
                        </th>
                        <th>
                            <?= $solution['code_length'] ?>
                        </th>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <hr>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($newSolution, 'language')->dropDownList($newSolution::getLanguageList()) ?>

    <?= $form->field($newSolution, 'source')->widget('app\widgets\codemirror\CodeMirror'); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>