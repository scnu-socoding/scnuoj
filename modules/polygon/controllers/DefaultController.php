<?php

namespace app\modules\polygon\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use app\modules\polygon\models\Problem;
use app\models\User;
use app\modules\polygon\models\ProblemSearch;
use app\components\AccessRule;
use yii\filters\AccessControl;

/**
 * Default controller for the `polygon` module
 */
class DefaultController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'ruleConfig' => [
                    'class' => AccessRule::class,
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [
                            User::ROLE_ADMIN,
                            User::ROLE_USER,
                            User::ROLE_VIP
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProblemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/problem/index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }
}
