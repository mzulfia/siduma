<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "service_family".
 *
 * @property integer $service_family_id
 * @property string $service_name
 */
class ServiceFamily extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'service_family';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'service_family_id' => 'Service Family ID',
            'service_name' => 'Service Name',
        ];
    }

    public function getServiceName($id){
        $array  = ServiceFamily::find()->where('service_family_id = :service_family_id', [':service_family_id' => $id])->one();
        if($array == null){
            return null;
        } else {
            return $array->service_name;
        }
    }
}
