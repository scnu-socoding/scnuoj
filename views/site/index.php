<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $contests array */
/* @var $news app\models\Discuss */

$this->title = Yii::$app->setting->get('ojName');
?>



<p></p>
<div class="row">
    <div class="col">
        <div>
            <?php foreach ($news as $v): ?>
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
                            $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                            $string .= '... ' . Html::a('继续阅读', ['/site/news', 'id' => $v['id']]);
                        }
                        echo $string;
                    ?>
            <hr>
            <?php endforeach; ?>
            <?= \yii\widgets\LinkPager::widget([
                'pagination' => $pages,
                'linkOptions' => ['class' => 'page-link text-dark'],
                'maxButtonCount' => 5,
            ]); ?>
        </div>
        <p></p>
    </div>
</div>