<?php

use yii\helpers\Html;
use app\models\Solution;

/* @var $this yii\web\View */
/* @var $status app\modules\polygon\models\PolygonStatus */

$this->title = $status->id;
// $this->params['breadcrumbs'][]][] = ['label' => Yii::t('app', 'Problems'), 'url' => ['index']];
// $this->params['breadcrumbs'][]][] = $this->title;
$this->params['model'] = $model;
?>


<div class="table-responsive">
    <table class="table table-rank">
        <thead>
            <tr>
                <th style="min-width:90px"><?= Yii::t('app', 'Run ID') ?></th>
                <th style="min-width:150px"><?= Yii::t('app', 'Author') ?></th>
                <th style="min-width:200px"><?= Yii::t('app', 'Problem ID') ?></th>
                <th style="min-width:90px"><?= Yii::t('app', 'Verdict') ?></th>
                <th style="min-width:90px"><?= Yii::t('app', 'Time') ?></th>
                <th style="min-width:90px"><?= Yii::t('app', 'Memory') ?></th>
                <th style="min-width:90px"><?= Yii::t('app', 'Lang') ?></th>
                <th style="min-width:90px"><?= Yii::t('app', 'Submit Time') ?></th>
            </tr>
        </thead>
        <tbody>
        <tr>
            <td><?= $status->id ?></td>
            <td><?= Html::a(Html::encode($status->user->nickname), ['/user/view', 'id' => $status->created_by]) ?></td>
            <td><?= Html::encode($model->title) ?></td>
            <td><?= Solution::getLanguageLiteList($status->language) ?></td>
            <td><?= Solution::getResultList($status->result) ?></td>
            <td><?= $status->time ?> MS</td>
            <td><?= $status->memory ?> KB</td>
            <td><?= $status->created_at ?></td>
        </tr>
        </tbody>
    </table>
</div>

<pre><code class="pre"><p style="font-size:1rem"><?= Html::encode($status->source) ?></p></code></pre>

<?php if ($status->info != null): ?>
    <hr>
    <h3>Run Info:</h3>
    <pre><?= \yii\helpers\HtmlPurifier::process($status->info) ?></pre>
<?php endif; ?>
