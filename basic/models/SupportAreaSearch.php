<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SupportArea;

/**
 * SupportAreaSearch represents the model behind the search form about `app\models\SupportArea`.
 */
class SupportAreaSearch extends SupportArea
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['support_area_id', 'support_id', 'service_family_id'], 'integer'],
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
        $query = SupportArea::find();

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
            'support_area_id' => $this->support_area_id,
            'support_id' => $this->support_id,
            'service_family_id' => $this->service_family_id,
        ]);

        return $dataProvider;
    }
}
