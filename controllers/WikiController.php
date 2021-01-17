<?php

namespace app\controllers;

use Yii;
use app\components\BaseController;
use yii\web\ForbiddenHttpException;

class WikiController extends BaseController
{
    public $layout = 'wiki';

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionFaq()
    {
        return $this->render('faq');
    }

    public function actionContest()
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()) {
            return $this->render('contest');
        }
        throw new ForbiddenHttpException('You are not allowed to perform this action.');
    }

    public function actionProblem()
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()) {
            return $this->render('problem');
        }
        throw new ForbiddenHttpException('You are not allowed to perform this action.');
    }

    public function actionSpj()
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()) {
            return $this->render('spj');
        }
        throw new ForbiddenHttpException('You are not allowed to perform this action.');
    }

    public function actionOi()
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()) {
            return $this->render('oi');
        }
        throw new ForbiddenHttpException('You are not allowed to perform this action.');
    }
}
