<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pic_position".
 *
 * @property integer $pic_position_id
 * @property string $position_name
 */
class PicPosition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pic_position';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['position_name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pic_position_id' => 'Pic Position ID',
            'position_name' => 'Position Name',
        ];
    } 

    /*
        get relation
    */

    public function getPics()
    {
        return $this->hasMany(Pic::className(), ['pic_position_id' => 'pic_position_id']);
    }
}
