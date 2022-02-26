<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Problem */
/* @var $solution app\models\Solution */
/* @var $submissions array */

$this->title = Yii::t('app', 'Editorial');

?>
<h3><?= Html::encode($model->id . '. ' . $model->title) ?> </h3>
<ul class="nav nav-pills">
    <li class="nav-item">
        <?= Html::a( Yii::t('app', 'Problem'),
            ['/problem/view', 'id' => $model->id],
            ['class' => 'nav-link'])
        ?>
    </li>
    <?php if (Yii::$app->setting->get('isDiscuss')): ?>
    <li class="nav-item">
        <?= Html::a( Yii::t('app', 'Discuss'),
            ['/problem/discuss', 'id' => $model->id],
            ['class' => 'nav-link'])
        ?>
    </li>
    <?php endif; ?>
    <?php if (!empty($model->solution)): ?>
    <li class="nav-item">
        <?= Html::a(Yii::t('app', 'Editorial'),
            ['/problem/solution', 'id' => $model->id],
            ['class' => 'nav-link active'])
        ?>
    </li>
    <?php endif; ?>
</ul>
<p></p>

<?= Yii::$app->formatter->asMarkdown($model->solution) ?>