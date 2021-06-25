<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\polygon\models\Problem */

$this->title = $model->title;
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Problems'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
$this->params['model'] = $model;
?>
<div class="row problem-view">
    <div class="col-lg-9">

        <?= Yii::$app->formatter->asMarkdown($model->description) ?>
        <p class="lead"><?= Yii::t('app', 'Input') ?></p>
        <?= Yii::$app->formatter->asMarkdown($model->input) ?>
        <p class="lead"><?= Yii::t('app', 'Output') ?></p>
        <?= Yii::$app->formatter->asMarkdown($model->output) ?>

        <?php if ($model->sample_input != '' || $model->sample_output != '') : ?>
            <p class="lead"><?= Yii::t('app', 'Examples') ?></p>
            <table class="table table-bordered" style="table-layout:fixed;">
                <tbody>
                    <tr class="bg-tablehead" style="line-height: 1;">
                        <td>标准输入</td>
                    </tr>
                    <tr>
                        <td>
                            <pre style="margin:0"><?= Html::encode($model->sample_input) ?></pre>
                        </td>
                    </tr>
                    <tr class="bg-tablehead" style="line-height: 1;">
                        <td>标准输出</td>
                    </tr>
                    <tr>
                        <td>
                            <pre style="margin:0"><?= Html::encode($model->sample_output) ?></pre>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>
        <?php if ($model->sample_input_2 != '' || $model->sample_output_2 != '') : ?>
            <table class="table table-bordered" style="table-layout:fixed;">
                <tbody>
                    <tr class="bg-tablehead" style="line-height: 1;">
                        <td>标准输入</td>
                    </tr>
                    <tr>
                        <td>
                            <pre style="margin:0"><?= Html::encode($model->sample_input_2) ?></pre>
                        </td>
                    </tr>
                    <tr class="bg-tablehead" style="line-height: 1;">
                        <td>标准输出</td>
                    </tr>
                    <tr>
                        <td>
                            <pre style="margin:0"><?= Html::encode($model->sample_output_2) ?></pre>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>
        <?php if ($model->sample_input_3 != '' || $model->sample_output_3 != '') : ?>
            <table class="table table-bordered" style="table-layout:fixed;">
                <tbody>
                    <tr class="bg-tablehead" style="line-height: 1;">
                        <td>标准输入</td>
                    </tr>
                    <tr>
                        <td>
                            <pre style="margin:0"><?= Html::encode($model->sample_input_3) ?></pre>
                        </td>
                    </tr>
                    <tr class="bg-tablehead" style="line-height: 1;">
                        <td>标准输出</td>
                    </tr>
                    <tr>
                        <td>
                            <pre style="margin:0"><?= Html::encode($model->sample_output_3) ?></pre>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>


        <?php if (!empty($model->hint)) : ?>
            <p class="lead"><?= Yii::t('app', 'Hint') ?></p>
            <?= Yii::$app->formatter->asMarkdown($model->hint) ?>
            <p></p>
        <?php endif; ?>
    </div>
    <div class="col-lg-3">
        <div class="list-group list-group-flush">

            <div class="list-group-item">
                单点时限 <a href="#" class="text-dark" data-toggle="tooltip" title="Java / Python 有 2s 额外运行时间">
                    <span class="fas fa-fw fa-info-circle"></span>
                </a>
                <span class="float-right">
                    <?= Yii::t('app', '{t, plural, =1{# second} other{# seconds}}', ['t' => intval($model->time_limit)]); ?>
                </span>
            </div>

            <div class="list-group-item">
                内存限制 <a href="#" class="text-dark" data-toggle="tooltip" title="Java / Python 有 64M 额外空间">
                    <span class="fas fa-fw fa-info-circle"></span>
                </a>
                <span class="float-right">
                    <?= $model->memory_limit ?> MB
                </span>
            </div>

        </div>
    </div>
</div>