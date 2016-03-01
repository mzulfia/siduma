<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "support_area".
 *
 * @property integer $support_area_id
 * @property integer $support_id
 * @property integer $service_family_id
 *
 * @property ServiceFamily $serviceFamily
 * @property Support $support
 */
class SupportArea extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'support_area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['support_id', 'service_family_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'support_area_id' => 'Support Area ID',
            'support_id' => 'Support ID',
            'service_family_id' => 'Service Family ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceFamily()
    {
        return $this->hasOne(ServiceFamily::className(), ['service_family_id' => 'service_family_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupport()
    {
        return $this->hasOne(Support::className(), ['support_id' => 'support_id']);
    }

    public function getServiceInCharge($id){
        $model = SupportArea::find()->where('support_id = :id', [':id' => $id])->all();
        if(sizeof($model) == 1){
            return ServiceFamily::getServiceName($model[0]['service_family_id']);
        } else if(sizeof($model) > 1){
            $service_name = '';
            for($i=0; $i < sizeof($model); $i++){
                if($i == sizeof($model)-1)
                    $service_name .= ServiceFamily::getServiceName($model[$i]['service_family_id']);
                else
                    $service_name .= ServiceFamily::getServiceName($model[$i]['service_family_id']) . "<br>";
            }
            return $service_name;
        } else {
            return null;
        }
    }
    
}
