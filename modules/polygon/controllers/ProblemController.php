<?php

namespace app\modules\polygon\controllers;

use app\models\Solution;
use app\modules\polygon\models\PolygonStatus;
use app\modules\polygon\models\ProblemSearch;
use Yii;
use app\models\User;
use app\modules\polygon\models\Problem;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use app\components\AccessRule;

/**
 * ProblemController implements the CRUD actions for Problem model.
 */
class ProblemController extends Controller
{
    public $enableCsrfValidation = false;
    public $layout = 'problem';
    /**
     * {@inheritdoc}
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
     * Lists all Problem models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->setting->get('isContestMode') && (Yii::$app->user->isGuest || (!Yii::$app->user->identity->isAdmin()))) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        $this->layout = '/main';
        $searchModel = new ProblemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    /**
     * 显示某个解决方案的详细信息
     * @param $id
     * @param $sid
     */
    public function actionSolutionDetail($id, $sid)
    {

        if (Yii::$app->setting->get('isContestMode') && (Yii::$app->user->isGuest || (!Yii::$app->user->identity->isAdmin()))) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        $this->layout = '/main';
        $model = $this->findModel($id);
        $status = PolygonStatus::findOne(['id' => $sid, 'problem_id' => $id]);
        if ($status === null) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

        return $this->render('detail', [
            'model' => $model,
            'status' => $status
        ]);
    }

    /**
     * 题解
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionAnswer($id)
    {

        if (Yii::$app->setting->get('isContestMode') && (Yii::$app->user->isGuest || (!Yii::$app->user->identity->isAdmin()))) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            return $this->refresh();
        }
        return $this->render('answer', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Problem model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        if (Yii::$app->setting->get('isContestMode') && (Yii::$app->user->isGuest || (!Yii::$app->user->identity->isAdmin()))) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        $model = $this->findModel($id);
        $model->setSamples();
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionRun($id)
    {

        if (Yii::$app->setting->get('isContestMode') && (Yii::$app->user->isGuest || (!Yii::$app->user->identity->isAdmin()))) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        $model = $this->findModel($id);
        if ($model->solution_lang === null || empty($model->solution_source)) {
            Yii::$app->session->setFlash('error', '请提供解决方案');
            return $this->redirect(['tests', 'id' => $id]);
        }
        Yii::$app->db->createCommand()->delete(
            '{{%polygon_status}}',
            'problem_id=:pid AND source IS NULL',
            [':pid' => $model->id]
        )->execute();
        Yii::$app->db->createCommand()->insert('{{%polygon_status}}', [
            'problem_id' => $model->id,
            'created_at' => new Expression('NOW()'),
            'created_by' => Yii::$app->user->id
        ])->execute();
        return $this->redirect(['tests', 'id' => $id]);
    }

    /**
     * Displays a single Problem model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionSpj($id)
    {

        if (Yii::$app->setting->get('isContestMode') && (Yii::$app->user->isGuest || (!Yii::$app->user->identity->isAdmin()))) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        $model = $this->findModel($id);

        if (!$model->spj) {
            Yii::$app->session->setFlash('error', '请先启用 Special Judge 判题。');
            return $this->redirect(['update', 'id' => $model->id]);
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->spj_lang = Solution::CPPLANG;
            $model->save();
            $dataPath = Yii::$app->params['polygonProblemDataPath'] . $model->id;
            if (!is_dir($dataPath)) {
                @mkdir($dataPath);
            }
            $fp = fopen($dataPath . '/spj.cc', "w");
            fputs($fp, $model->spj_source);
            fclose($fp);
            exec("g++ -fno-asm -std=c++20 -O2 {$dataPath}/spj.cc -o {$dataPath}/spj -I" . Yii::getAlias('@app/libraries'));
            return $this->redirect(['spj', 'id' => $model->id]);
        }
        return $this->render('spj', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Problem model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionSolution($id)
    {

        if (Yii::$app->setting->get('isContestMode') && (Yii::$app->user->isGuest || (!Yii::$app->user->identity->isAdmin()))) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        $model = $this->findModel($id);
        if ($model->solution_lang == null) {
            $model->solution_lang = Yii::$app->user->identity->language;
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['solution', 'id' => $model->id]);
        }
        return $this->render('solution', [
            'model' => $model,
        ]);
    }

    /**
     * 验题页面
     * @param integer $id
     * @return mixed
     */
    public function actionVerify($id)
    {

        if (Yii::$app->setting->get('isContestMode') && (Yii::$app->user->isGuest || (!Yii::$app->user->identity->isAdmin()))) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        $model = $this->findModel($id);

        if (isset($model->spj) && $model->spj) {
            Yii::$app->session->setFlash('error', 'Special Judge 题目需在管理员后台进行验题。');
            return $this->redirect(['update', 'id' => $model->id]);
        }

        $solution = new PolygonStatus();
        $dataProvider = new ActiveDataProvider([
            'query' => PolygonStatus::find()->where('problem_id=:pid AND source IS NOT NULL', [':pid' => $id]),
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        if ($solution->load(Yii::$app->request->post())) {
            $solution->problem_id = $id;
            $solution->created_by = Yii::$app->user->id;
            $solution->created_at = new Expression('NOW()');
            $solution->save();
            return $this->refresh();
        }
        return $this->render('verify', [
            'model' => $model,
            'solution' => $solution,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionTests($id)
    {

        if (Yii::$app->setting->get('isContestMode') && (Yii::$app->user->isGuest || (!Yii::$app->user->identity->isAdmin()))) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        $model = $this->findModel($id);
        $solutionStatus = Yii::$app->db->createCommand("SELECT * FROM {{%polygon_status}} WHERE problem_id=:pid AND language IS NULL", [
            ':pid' => $model->id
        ])->queryOne();
        if (Yii::$app->request->isPost) {
            $ext = substr(strrchr($_FILES["file"]["name"], '.'), 1);
            if ($ext != 'in' && $ext != 'out' && $ext != 'ans') {
                throw new BadRequestHttpException($ext);
            }
            $inputFile = file_get_contents($_FILES["file"]["tmp_name"]);
            file_put_contents($_FILES["file"]["tmp_name"], preg_replace("(\r\n)", "\n", $inputFile));
            @move_uploaded_file($_FILES["file"]["tmp_name"], Yii::$app->params['polygonProblemDataPath'] . $model->id . '/' . $_FILES["file"]["name"]);
        }
        return $this->render('tests', [
            'model' => $model,
            'solutionStatus' => $solutionStatus
        ]);
    }


    /**
     * 下载测试数据
     */
    public function actionDownloadData($id)
    {

        if (Yii::$app->setting->get('isContestMode') && (Yii::$app->user->isGuest || (!Yii::$app->user->identity->isAdmin()))) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        $model = $this->findModel($id);
        $filename = Yii::$app->params['polygonProblemDataPath'] . $model->id;
        $zipName = '/tmp/' . time() . $id . '.zip';
        if (!file_exists($filename)) {
            return false;
        }
        $zipArc = new \ZipArchive();
        if (!$zipArc->open($zipName, \ZipArchive::CREATE)) {
            return false;
        }
        $res = $zipArc->addGlob("{$filename}/*", GLOB_BRACE, ['remove_all_path' => true]);
        $zipArc->close();
        if (!$res) {
            return false;
        }
        if (!file_exists($zipName)) {
            return false;
        }
        Yii::$app->response->on(\yii\web\Response::EVENT_AFTER_SEND, function ($event) {
            unlink($event->data);
        }, $zipName);
        return Yii::$app->response->sendFile($zipName, $model->id . '-' . $model->title . '.zip');
    }

    public function actionDeletefile($id, $name)
    {

        if (Yii::$app->setting->get('isContestMode') && (Yii::$app->user->isGuest || (!Yii::$app->user->identity->isAdmin()))) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        $model = $this->findModel($id);
        $name = basename($name);
        if ($name == 'in') {
            $files = $model->getDataFiles();
            foreach ($files as $file) {
                if (strpos($file['name'], '.in')) {
                    @unlink(Yii::$app->params['polygonProblemDataPath'] . $model->id . '/' . $file['name']);
                }
            }
        } else if ($name == 'out') {
            $files = $model->getDataFiles();
            foreach ($files as $file) {
                if (strpos($file['name'], '.out')) {
                    @unlink(Yii::$app->params['polygonProblemDataPath'] . $model->id . '/' . $file['name']);
                }
                if (strpos($file['name'], '.ans')) {
                    @unlink(Yii::$app->params['polygonProblemDataPath'] . $model->id . '/' . $file['name']);
                }
            }
        } else if (strpos($name, '.in') || strpos($name, '.out') || strpos($name, '.ans')) {
            @unlink(Yii::$app->params['polygonProblemDataPath'] . $model->id . '/' . $name);
        }
        return $this->redirect(['tests', 'id' => $model->id]);
    }

    public function actionViewfile($id, $name)
    {

        if (Yii::$app->setting->get('isContestMode') && (Yii::$app->user->isGuest || (!Yii::$app->user->identity->isAdmin()))) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        $model = $this->findModel($id);
        $name = basename($name);
        if (strpos($name, '.in') || strpos($name, '.out') || strpos($name, '.ans')) {
            $filepath = Yii::$app->params['polygonProblemDataPath'] . $model->id . '/' . $name;
            $fp = fopen($filepath, 'r');
            echo '<pre>';
            while (!feof($fp)) {
                $content = fread($fp, 1024);
                echo $content;
            }
            echo '</pre>';
            fclose($fp);
        }
        die;
    }

    /**
     * Creates a new Problem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        if (Yii::$app->setting->get('isContestMode') && (Yii::$app->user->isGuest || (!Yii::$app->user->identity->isAdmin()))) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        $this->layout = '/main';
        $model = new Problem();

        if ($model->load(Yii::$app->request->post())) {
            $sample_input = [$model->sample_input, $model->sample_input_2, $model->sample_input_3];
            $sample_output = [$model->sample_output, $model->sample_output_2, $model->sample_output_3];
            $model->sample_input = serialize($sample_input);
            $model->sample_output = serialize($sample_output);
            if ($model->save()) {
                @mkdir(Yii::$app->params['polygonProblemDataPath'] . $model->id);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        $model->time_limit = 1;
        $model->memory_limit = 256;
        $model->spj = 0;

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Problem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        if (Yii::$app->setting->get('isContestMode') && (Yii::$app->user->isGuest || (!Yii::$app->user->identity->isAdmin()))) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $sample_input = [$model->sample_input, $model->sample_input_2, $model->sample_input_3];
            $sample_output = [$model->sample_output, $model->sample_output_2, $model->sample_output_3];
            $model->sample_input = serialize($sample_input);
            $model->sample_output = serialize($sample_output);
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $model->setSamples();

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionSubtask($id)
    {

        if (Yii::$app->setting->get('isContestMode') && (Yii::$app->user->isGuest || (!Yii::$app->user->identity->isAdmin()))) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        $model = $this->findModel($id);

        if (!Yii::$app->setting->get('oiMode')) {
            Yii::$app->session->setFlash('error', '请先启用 OI 模式。');
            return $this->redirect(['update', 'id' => $model->id]);
        }

        $dataPath = Yii::$app->params['polygonProblemDataPath'] . $model->id;
        $subtaskContent = '';

        if (file_exists($dataPath . '/config')) {
            $subtaskContent = file_get_contents($dataPath . '/config');
        }
        if (Yii::$app->request->isPost) {
            $spjContent = Yii::$app->request->post('subtaskContent');
            if (!is_dir($dataPath)) {
                mkdir($dataPath);
            }
            $fp = fopen($dataPath . '/config', "w");
            fputs($fp, $spjContent);
            fclose($fp);
        }
        return $this->render('subtask', [
            'model' => $model,
            'subtaskContent' => $subtaskContent
        ]);
    }

    /**
     * Deletes an existing Problem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        if (Yii::$app->setting->get('isContestMode') && (Yii::$app->user->isGuest || (!Yii::$app->user->identity->isAdmin()))) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Problem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Problem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     * @throws ForbiddenHttpException if the model cannot be viewed
     */
    protected function findModel($id)
    {
        if (($model = Problem::findOne($id)) !== null) {
            if (
                Yii::$app->user->id === $model->created_by ||
                Yii::$app->user->identity->role === User::ROLE_ADMIN
            ) {
                return $model;
            } else {
                throw new ForbiddenHttpException('You are not allowed to perform this action.');
            }
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
