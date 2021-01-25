<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ContestPrint */

$this->title = '查看打印详情';
// $this->params['breadcrumbs'][] = ['label' => $model->contest->title, 'url' => ['/contest/view', 'id' => $model->contest_id]];
// $this->params['breadcrumbs'][] = ['label' => 'Print Sources', 'url' => ['index', 'id' => $model->contest_id]];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="print-source-view">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width:4rem;min-width:4rem">
                    #
                </th>
                <th>
                    比赛
                </th>
                <th>
                    用户
                </th>
                <th>
                    账户
                </th>
                <th style="width:7rem;min-width:7rem">
                    时间
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <?= $model->id ?>
                </td>
                <td>
                <?= Html::a(Html::encode($model->contest->title), ['/contest/view', 'id' => $model->contest_id], ['class' => 'text-dark']); ?>
                </td>
                <td>
                    <?= Html::a(Html::encode($model->user->nickname ?? '临时用户'), ['/user/view', 'id' => $model->user->id], ['class' => 'text-dark']); ?>
                </td>
                <td>
                <?= Html::a(Html::encode($model->user->username), ['/user/view', 'id' => $model->user->id], ['class' => 'text-dark']); ?>
                </td>
                <td>
                    <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?>
                </td>
            </tr>
        </tbody>
    </table>

    <pre><code class="pre"><p><?= Html::encode($model->source) ?></p></code></pre>

</div>