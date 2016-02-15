<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "management".
 *
 * @property integer $management_id
 * @property integer $mgt_nip
 * @property string $mgt_name
 * @property string $mgt_position
 * @property integer $user_id
 */
class Management extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'management';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mgt_nip', 'user_id'], 'integer'],
            [['mgt_name', 'mgt_position'], 'string', 'max' => 50],
            [['mgt_nip'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'management_id' => 'Management ID',
            'mgt_nip' => 'Mgt Nip',
            'mgt_name' => 'Mgt Name',
            'mgt_position' => 'Mgt Position',
            'user_id' => 'User ID',
        ];
    }
}
