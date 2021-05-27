<?php

use app\models\User;
use yii\bootstrap4\Nav;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Groups');
?>
<?php
$DefGp = false;
if (Yii::$app->user->isGuest || Yii::$app->setting->get('isDefGroup') == 0) {
    $DefGp = false;
} elseif ((Yii::$app->setting->get('isDefGroup') == 2) && (Yii::$app->user->identity->role === User::ROLE_ADMIN)) {
    $DefGp = true;
} elseif (Yii::$app->setting->get('isDefGroup') == 3 && (Yii::$app->user->identity->role === User::ROLE_ADMIN || Yii::$app->user->identity->role === User::ROLE_VIP)) {
    $DefGp = true;
} else {
    $DefGp = false;
}
?>

<?php if (!Yii::$app->user->isGuest) : ?>
    <?= Nav::widget([
        'items' => [
            [
                'label' => Yii::t('app', 'My Groups'),
                'url' => ['group/my-group'],
                'visible' => !Yii::$app->user->isGuest,
            ],
            [
                'label' => Yii::t('app', 'Explore'),
                'url' => ['group/index'],
            ],
            [
                'label' => Yii::t('app', 'Create'),
                'url' => 'create',
                'visible' => $DefGp,
                'options' => ['class' => 'ml-auto'],
            ]
        ],
        'options' => ['class' => 'nav-pills']
    ]) ?>
    <p></p>
<?php endif; ?>

<?php echo $this->render('_search', ['model' => $searchModel]); ?>

<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_group_item',
    'itemOptions' => ['tag' => false],
    'layout' => '{items}<p></p>{pager}',
    'options' => ['class' => 'list-group animate__animated animate__fadeIn animate__faster'],
    'pager' => [
        'linkOptions' => ['class' => 'page-link'],
        'maxButtonCount' => 5,
    ]
]) ?>