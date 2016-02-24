<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "support".
 *
 * @property integer $support_id
 * @property integer $
 * @property string $support_name
 * @property string $company
 * @property integer $no_hp
 * @property integer $support_position_id
 * @property integer $user_id
 */
class Support extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'support';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['support_position_id', 'user_id'], 'integer'],
            [['no_hp'], 'string', 'max' => 20],
            [['support_name', 'company', 'email'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'support_id' => 'Support ID',
            'support_name' => 'Support Name',
            'company' => 'Company',
            'no_hp' => 'No Hp',
            'email' => 'Email',
            'support_position_id' => 'Position',
            'user_id' => 'User ID',
        ];
    }

    /*
        get relation
    */
    public function getPos()
    {
        return $this->hasOne(SupportPosition::className(), ['support_position_id' => 'support_position_id']);
    }

    public function getSchedules()
    {
        return $this->hasMany(Schedule::className(), ['support_id' => 'support_id']);
    }
}
