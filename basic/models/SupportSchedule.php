<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "support_schedule".
 *
 * @property integer $support_schedule_id
 * @property integer $support_id
 * @property integer $schedule_id
 * @property integer $is_pic
 */
class SupportSchedule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'support_schedule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['support_id', 'schedule_id', 'is_pic'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'support_schedule_id' => 'Support Schedule ID',
            'support_id' => 'Support ID',
            'schedule_id' => 'Schedule ID',
            'is_pic' => 'Is Pic',
        ];
    }

    /*
        get the relations
    */
}
