<?php

namespace app\controllers;

use app\components\BaseController;
use app\models\Contest;
use Yii;
use app\models\Solution;
use app\models\SolutionSearch;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;

/**
 * SolutionController implements the CRUD actions for Solution model.
 */
class SolutionController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Solution models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SolutionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (!Yii::$app->setting->get('isContestMode') || (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin())) {
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }
    }

    /**
     * 返回提交状态供 AJAX 查询
     * @param $id
     * @return false|string
     * @throws NotFoundHttpException
     */
    public function actionVerdict($id)
    {
        $query = Yii::$app->db->createCommand('SELECT id,result,contest_id FROM {{%solution}} WHERE id=:id', [
            ':id' => $id
        ])->queryOne();

        if (!empty($query['contest_id'])) {
            $contest = Solution::getContestInfo($query['contest_id']);
            if ($contest['type'] == Contest::TYPE_OI) {
                $query['result'] = 0;
            }
        }
        $res = [
            'id' => $query['id'],
            'verdict' => $query['result'],
            'waiting' => $query['result'] <= Solution::OJ_WAITING_STATUS ? 'true' : 'false',
            'result' => Solution::getResultList($query['result'])
        ];
        return json_encode($res);
    }

    /**
     * Displays source of a single Solution model.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be viewed.
     * @throws NotFoundHttpException
     */
    public function actionSource($id)
    {
        $this->layout = false;
        $model = $this->findModel($id);

        return $this->render('source', [
            'model' => $model,
        ]);
    }

    /**
     * 提交记录的详细信息
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionDetail($id)
    {
        $this->layout = 'main';
        $model = $this->findModel($id);

        if (!Yii::$app->setting->get('isContestMode') || (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()) || $model->canViewSource()) {
            return $this->render('detail', [
                'model' => $model,
            ]);
        } else {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }
    }

    /**
     * Finds the Solution model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Solution the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Solution::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
