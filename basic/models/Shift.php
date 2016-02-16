<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "shift".
 *
 * @property integer $shift_id
 * @property string $shift_name
 * @property string $shift_start
 * @property string $shift_end
 */
class Shift extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shift';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shift_start', 'shift_end'], 'safe'],
            [['shift_name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'shift_id' => 'Shift ID',
            'shift_name' => 'Shift Name',
            'shift_start' => 'Shift Start',
            'shift_end' => 'Shift End',
        ];
    }
}
