<?php

use app\models\User;
use yii\helpers\Html;

use app\models\User;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;

/* @var $this yii\web\View */
/* @var $model app\models\Group */

if (Yii::$app->user->identity->role !== User::ROLE_ADMIN && Yii::$app->user->identity->role !== User::ROLE_VIP) {
    throw new ForbiddenHttpException('You are not allowed to perform this action.');
}

$this->title = Yii::t('app', 'Create Group');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$DefGp = false;
if(Yii::$app->user->isGuest || Yii::$app->setting->get('isDefGroup') == 0)
{
    $DefGp = false; 
}
elseif ((Yii::$app->setting->get('isDefGroup')==2) && (Yii::$app->user->identity->role === User::ROLE_ADMIN) ) {
    $DefGp = true; 
}
elseif(Yii::$app->setting->get('isDefGroup')==3 && (Yii::$app->user->identity->role === User::ROLE_ADMIN || Yii::$app->user->identity->role === User::ROLE_VIP)){
    $DefGp = true; 
}
else{
    $DefGp = false;  
}



?>
<div class="group-create">
    <?php if ($DefGp): ?>    
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    <?php else: ?>
       <h3> 没有创建小组的权限！</h3>
    <?php endif; ?>   
</div>
