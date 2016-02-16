<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SupportSchedule;

/**
 * SupportScheduleSearch represents the model behind the search form about `app\models\SupportSchedule`.
 */
class SupportScheduleSearch extends SupportSchedule
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['support_schedule_id', 'support_id', 'schedule_id', 'is_pic'], 'integer'],
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
        $query = SupportSchedule::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'support_schedule_id' => $this->support_schedule_id,
            'support_id' => $this->support_id,
            'schedule_id' => $this->schedule_id,
            'is_pic' => $this->is_pic,
        ]);

        return $dataProvider;
    }
}
