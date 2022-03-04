<?php

namespace app\modules\polygon\controllers;

use yii\web\Controller;

/**
 * Default controller for the `polygon` module
 */
class DefaultController extends Controller
{
    public function actionIndex()
    {
        $this->redirect("/polygon/problem/index");
    }
}
