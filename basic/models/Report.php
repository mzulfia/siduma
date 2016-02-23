<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "report".
 *
 * @property integer $report_id
 * @property integer $status
 * @property string $information
 * @property string $created_at
 * @property integer $service_family_id
 */
class Report extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'report';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'support_id', 'service_family_id'], 'integer'],
            [['information'], 'string'],
            [['created_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'report_id' => 'Report ID',
            'status' => 'Status',
            'information' => 'Information',
            'created_at' => 'Created At',
            'support_id' => 'Support ID',
            'service_family_id' => 'Service Family ID',
        ];
    }

    /*
        get the relations
    */

    public function getService(){
        return $this->hasOne(ServiceFamily::className(), ['service_family_id' => 'service_family_id']);
    }

    public function getSupport(){
        return $this->hasOne(Support::className(), ['support_id' => 'support_id']);
    }
}
