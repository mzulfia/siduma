<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pic;

/**
 * PicSearch represents the model behind the search form about `app\models\Pic`.
 */
class PicSearch extends Pic
{
     public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['pic_position_id']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pic_id', 'pic_nip', 'no_hp', 'pic_position_id', 'user_id'], 'integer'],
            [['pic_name', 'company'], 'safe'],
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
        $query = Pic::find();

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
            'pic_id' => $this->pic_id,
            'pic_nip' => $this->pic_nip,
            'no_hp' => $this->no_hp,
            'pic_position_id' => $this->pic_position_id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'pic_name', $this->pic_name])
            ->andFilterWhere(['like', 'company', $this->company]);

        return $dataProvider;
    }
}
