<?php

namespace app\controllers;

use app\components\BaseController;
use app\models\UserProfile;
use Yii;
use app\models\User;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends BaseController
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
            'access' => [
                'class' => AccessControl::class,
                'only' => ['setting', 'verify-email'],
                'rules' => [
                    [
                        'actions' => ['setting', 'verify-email'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * 用户主页
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * 设置用户信息
     * @param string $action
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be viewed
     */
    public function actionSetting($action = 'default')
    {
        $model = User::findOne(Yii::$app->user->id);
        if ($model->role === User::ROLE_PLAYER) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }
        switch ($action) {
            case 'default':
                $model->scenario = 'default';
                break;
            case 'security':
                $model->scenario = 'security';
                break;
            default:
                $action = 'default';
                break;
        }
        $oldEmail = $model->email;
        $profile = UserProfile::findOne($model->id);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->scenario == 'security') {
                    $model->setPassword($model->newPassword);
                }
            }
            if ($oldEmail != $model->email) {
                $model->is_verify_email = User::VERIFY_EMAIL_NO;
            }
            $model->save();
            if ($profile->load(Yii::$app->request->post())) {
                $profile->save();
            }
            Yii::$app->session->setFlash('success', Yii::t('app', 'Saved successfully'));
            return $this->refresh();
        }

        return $this->render('setting', [
            'model' => $model,
            'action' => $action,
            'profile' => $profile
        ]);
    }

    /**
     * @param $email
     * @throws NotFoundHttpException
     */
    public function actionVerifyEmail()
    {
        $user = User::findOne(Yii::$app->user->id);
        $user->generateEmailVerificationToken();
        $user->update(false);
        $res = Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->setting->get('emailUsername') => Yii::$app->setting->get('ojName')])
            ->setTo($user->email)
            ->setSubject('邮箱验证 - ' . Yii::$app->setting->get('ojName'))
            ->send();
        if ($res) {
            Yii::$app->session->setFlash('success', '已发送验证链接到您的邮箱：' . $user->email . '，请查收并点击验证链接进行确认。');
        } else {
            Yii::$app->session->setFlash('error', '验证邮箱发送失败。可能原因：1. 该邮箱不存在；2. 本网站系统邮箱配置信息有误，需联系管理员检查系统的发送邮箱配置信息。');
        }
        $this->redirect(['/user/setting', 'action' => 'default']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (is_numeric($id)) {
            $model = User::findOne($id);
        } else {
            $model = User::find()->where(['username' => $id])->one();
        }

        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
