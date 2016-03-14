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
            [['support_area_id'], 'integer'],
            [['service_family_id', 'support_id'], 'safe'],
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

        $dataProvider->sort->attributes['support_id'] = [
              'asc' => ['support.support_name' => SORT_ASC],
              'desc' => ['support.support_name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['service_family_id'] = [
              'asc' => ['service_family.service_name' => SORT_ASC],
              'desc' => ['service_family.service_name' => SORT_DESC],
        ];

        if (isset($_GET['SupportAreaSearch']) && !($this->load($params) && $this->validate())) {
            return $dataProvider; 
        }

        $query->joinWith(['support', 'serviceFamily']);

        $query->andFilterWhere([
            'service_family.service_family_id' => $this->service_family_id
        ]);

        $query->andFilterWhere(['like', 'support.support_name', $this->support_id]);

        return $dataProvider;
    }
}
