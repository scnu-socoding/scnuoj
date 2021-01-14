<?php

use yii\helpers\Html;
?>

<?php if ($model['description']) : ?>
    <?= Html::a(Html::encode($model['name']) . '<br><small>' . Html::encode($model['description']) . '</small>', ['/group/view', 'id' => $model['id']], ['class' => 'list-group-item list-group-item-action']) ?>
<?php else : ?>
    <?= Html::a(Html::encode($model['name']), ['/group/view', 'id' => $model['id']], ['class' => 'list-group-item list-group-item-action']) ?>
<?php endif; ?>