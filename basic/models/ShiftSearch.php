<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Shift;

/**
 * ShiftSearch represents the model behind the search form about `app\models\Shift`.
 */
class ShiftSearch extends Shift
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shift_id'], 'integer'],
            [['shift_name', 'shift_start', 'shift_end'], 'safe'],
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
        $query = Shift::find();

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
            'shift_id' => $this->shift_id,
            'shift_start' => $this->shift_start,
            'shift_end' => $this->shift_end,
        ]);

        $query->andFilterWhere(['like', 'shift_name', $this->shift_name]);

        return $dataProvider;
    }
}
