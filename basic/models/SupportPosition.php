<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "support_position".
 *
 * @property integer $support_position_id
 * @property string $position_name
 */
class SupportPosition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'support_position';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['position_name'], 'required'],
            [['position_name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'support_position_id' => 'Position',
            'position_name' => 'Position Name',
        ];
    } 

    /*
        get relation
    */

    public function getSupports()
    {
        return $this->hasMany(Support::className(), ['support_position_id' => 'support_position_id']);
    }

    public function getPosition($id){
        $model = SupportPosition::find()->where('support_position_id = :id', [':id' => $id])->one();
        if(!empty($model)){
            return $model->position_name;
        } else {
            return null;
        }
    }
}
