<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pic".
 *
 * @property integer $pic_id
 * @property integer $pic_nip
 * @property string $pic_name
 * @property string $company
 * @property integer $no_hp
 * @property integer $pic_position_id
 * @property integer $user_id
 */
class Pic extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pic';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pic_nip', 'pic_position_id', 'user_id'], 'integer'],
            [['no_hp'], 'string', 'max' => 20],
            [['pic_name', 'company'], 'string', 'max' => 50],
            [['pic_nip'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pic_id' => 'Pic ID',
            'pic_nip' => 'Pic Nip',
            'pic_name' => 'Pic Name',
            'company' => 'Company',
            'no_hp' => 'No Hp',
            'pic_position_id' => 'Pic Position ID',
            'user_id' => 'User ID',
        ];
    }

    /*
        get relation
    */
    public function getPos()
    {
        return $this->hasOne(PicPosition::className(), ['pic_position_id' => 'pic_position_id']);
    }

    public function getSchedules()
    {
        return $this->hasMany(Schedule::className(), ['pic_id' => 'pic_id']);
    }
}
