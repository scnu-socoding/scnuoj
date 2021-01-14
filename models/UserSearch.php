<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\Model\UserProfile;

/**
 * SolutionSearch represents the model behind the search form of `app\models\Solution`.
 */
class UserSearch extends User
{
    public $username;
    public $student_number;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'student_number'], 'integer'],
            [['username', 'email', 'nickname'], 'string'],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            ['role', 'in', 'range' => [self::ROLE_PLAYER, self::ROLE_USER, self::ROLE_VIP, self::ROLE_ADMIN]]
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy(['id' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $user_id = (new Query())->select('user_id')
            ->from('{{%user_profile}}')
            ->andWhere('student_number=:name', [':name' => $this->student_number]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'role' => $this->role,
        ]);

        if ($this->student_number) {
            $query->andFilterWhere([
                'id' => $user_id,
            ]);
        }


        $query->andFilterWhere(['like', 'nickname', $this->nickname])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
