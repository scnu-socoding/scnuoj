<?php

namespace app\controllers;

use app\components\BaseController;

class BoardController extends BaseController
{
    public $layout = 'board';
    public function actionScnucpc2020()
    {
        return $this->render('scnucpc2020');
    }
    public function actionScnucpc2021()
    {
        return $this->render('scnucpc2021');
    }
}
