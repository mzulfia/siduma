<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pic_area".
 *
 * @property integer $pic_area_id
 * @property integer $pln_pic_id
 * @property integer $service_family_id
 *
 * @property PlnPic $plnPic
 * @property ServiceFamily $serviceFamily
 */
class PicArea extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pic_area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pln_pic_id', 'service_family_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pic_area_id' => 'Pic Area ID',
            'pln_pic_id' => 'Pln Pic ID',
            'service_family_id' => 'Service Family ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlnPic()
    {
        return $this->hasOne(PlnPic::className(), ['pln_pic_id' => 'pln_pic_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceFamily()
    {
        return $this->hasOne(ServiceFamily::className(), ['service_family_id' => 'service_family_id']);
    }


    /*
        getter
    */

    public function getServiceInCharge($id){
        $model = PicArea::find()->where('pln_pic_id = :id', [':id' => $id])->all();
        if(sizeof($model) == 1){
            return ServiceFamily::getServiceName($model[0]['service_family_id']);
        } else if(sizeof($model) > 1){
            $service_name = '';
            for($i=0; $i < sizeof($model); $i++){
                if($i == sizeof($model)-1)
                    $service_name .= ServiceFamily::getServiceName($model[$i]['service_family_id']);
                else
                    $service_name .= ServiceFamily::getServiceName($model[$i]['service_family_id']) . "/";
            }
            return $service_name;
        } else {
            return null;
        }
    }
}
