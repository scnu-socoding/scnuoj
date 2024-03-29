<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $contests array */
/* @var $news app\models\Discuss */

$this->title = Yii::$app->setting->get('ojName');
?>

<section class="py-5 text-center">
    <div class="row py-lg-5">
        <div class="mx-auto">
            <br />
            <h2><?= Yii::$app->setting->get('ojName') ?></h2>
            <p class="lead text-muted"><?= Yii::$app->setting->get('schoolName') ?>在线评测系统</p>
        </div>
    </div>
</section>

<p></p>
<div class="row">
    <div class="col">
        <div>
            <?php foreach ($news as $v) : ?>
                <div class="animate__animated animate__fadeInUp animate__fast">
                    <h5 class="card-title">
                        <?= Html::a(Html::encode($v['title']), ['/site/news', 'id' => $v['id']], ['class' => 'text-dark']) ?>
                    </h5>
                    <?php
                    $string = strip_tags(Yii::$app->formatter->asMarkdown($v['content']));
                    if (strlen($string) > 1000) {

                        // truncate string
                        $stringCut = substr($string, 0, 1000);
                        $endPoint = strrpos($stringCut, ' ');

                        //if the string doesn't contain any space then it will cut without word basis.
                        $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                        $string .= '... ' . Html::a('继续阅读', ['/site/news', 'id' => $v['id']]);
                    }
                    echo $string;
                    ?>
                    <hr>
                </div>
            <?php endforeach; ?>
            <?= \yii\widgets\LinkPager::widget([
                'pagination' => $pages,
                'linkOptions' => ['class' => 'page-link'],
                'maxButtonCount' => 5,
            ]); ?>
        </div>
        <p></p>
    </div>
</div>