<?php

namespace app\controllers;

use app\components\BaseController;
use app\models\User;
use yii\db\Query;
use yii\data\Pagination;
use yii\web\ForbiddenHttpException;
use Yii;

class RatingController extends BaseController
{
    public function actionIndex()
    {

        if (Yii::$app->setting->get('isContestMode') && (Yii::$app->user->isGuest || (!Yii::$app->user->identity->isAdmin()))) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }
        $query = (new Query())->select('u.id, u.nickname, p.student_number, u.rating, s.solved')
            ->from('{{%user}} AS u')
            ->leftJoin(
                '(SELECT COUNT(DISTINCT problem_id) AS solved, created_by FROM {{%solution}} WHERE result=4 GROUP BY created_by ORDER BY solved DESC) as s',
                'u.id=s.created_by'
            )
            ->leftJoin('`user_profile` `p` ON `p`.`user_id`=`u`.`id`')
            ->orderBy('solved DESC, id');
        $top3users = $query->limit(3)->all();
        $defaultPageSize = 50;
        $countQuery = clone $query;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => $defaultPageSize
        ]);
        $users = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'top3users' => $top3users,
            'users' => $users,
            'pages' => $pages,
            'currentPage' => $pages->page,
            'defaultPageSize' => $defaultPageSize
        ]);
    }
}
