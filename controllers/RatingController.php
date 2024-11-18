<?php

namespace app\controllers;

use app\components\BaseController;
use yii\db\Query;
use yii\db\Expression;
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
            $query = (new Query())->select([
                'u.id',
                'u.nickname',
                'p.student_number',
                'u.rating',
                new Expression('IF(s.solved IS NULL, 0, s.solved) as solved')
            ])
                ->from('{{%user}} AS u')
                ->leftJoin(
                    '(SELECT COUNT(DISTINCT problem_id) AS solved, created_by FROM {{%solution}} WHERE result=4 GROUP BY created_by) as s',
                    'u.id=s.created_by'
                )
                ->leftJoin('`user_profile` `p` ON `p`.`user_id`=`u`.`id`')
                ->orderBy('s.solved DESC, u.id');
            // 修改此处以获取所有用户数据
            $allUsers = $query->all();
            // 将查询结果和当前时间保存到缓存中
            $currentTimestamp = time();
            // 缓存全体数据，设置有效期为 600 秒（10分钟）
            $data = [
                'allUsers' => $allUsers,
                'lastUpdated' => $currentTimestamp
            ];
            Yii::$app->cache->set($cacheKey, $data, 600);
        }

        // 分页处理
        // 假设从前端获取当前页码（pageNum）和每页大小（pageSize）
        $defaultPageSize = 50;
        $pages = new Pagination([
            'totalCount' => count($data['allUsers']),
            'defaultPageSize' => $defaultPageSize
        ]);
        $pageNum = Yii::$app->request->get('page', 1);
        $pageSize = Yii::$app->request->get('pageSize', $defaultPageSize);
        $offset = ($pageNum - 1) * $pageSize;
        $pagedData = array_slice($data['allUsers'], $offset, $pageSize);

        // 使用缓存或新查询的数据渲染视图
        // 向视图传递分页数据和其他必要信息
        return $this->render('index', [
            'users' => $pagedData,
            'currentPage' => $pageNum,
            'defaultPageSize' => $defaultPageSize,
            'pages' => $pages,
            'totalUsers' => count($data['allUsers']),
            'lastUpdated' => $data['lastUpdated']
        ]);
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
