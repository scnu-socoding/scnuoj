<?php

namespace app\controllers;

use app\components\BaseController;
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

        // 缓存键
        $cacheKey = 'rating-index-data';
        // 尝试从缓存中获取数据
        $data = Yii::$app->cache->get($cacheKey);

        if ($data === false) {
            // 缓存中没有数据，执行数据库查询
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

            // 将查询结果和当前时间保存到缓存中
            $currentTimestamp = time();
            // 将查询结果保存到缓存中，设置有效期为 600 秒（10分钟）
            $data = [
                'top3users' => $top3users,
                'users' => $users,
                'pages' => $pages,
                'currentPage' => $pages->page,
                'defaultPageSize' => $defaultPageSize,
                'lastUpdated' => $currentTimestamp
            ];
            Yii::$app->cache->set($cacheKey, $data, 600);
        }

        // 使用缓存或新查询的数据渲染视图
        return $this->render('index', $data);
    }

    public function actionClearCache()
    {
        if (Yii::$app->user->isGuest || !Yii::$app->user->identity->isAdmin()) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }
        Yii::$app->cache->delete('rating-index-data');
        Yii::$app->session->setFlash('success', 'Cache cleared successfully.');
        return $this->redirect(['index']); // 重定向回主页面
    }

}
