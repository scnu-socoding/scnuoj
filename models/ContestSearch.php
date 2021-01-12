<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Contest;

/**
 * ContestSearch represents the model behind the search form of `app\models\Contest`.
 */
class ContestSearch extends Contest
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['title'], 'safe'],
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Contest::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->FilterWhere(['like', 'title', $this->title])
        ->andwhere([
            '<>', 'status', Contest::STATUS_HIDDEN
        ])->andWhere([
            'group_id' => 0
        ])->orderBy(['start_time' => SORT_DESC, 'end_time' => SORT_ASC, 'id' => SORT_DESC]);

        return $dataProvider;
    }
}
