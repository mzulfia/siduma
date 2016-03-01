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
    const IMAGE_PLACEHOLDER = '/uploads/profile_pictures/default_user.png';

    public $file;

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
            [['image_path'], 'string', 'max' => 255],
            [['file'], 'file', 'maxSize'=>'200000'],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, png']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'support_id' => 'Support ID',
            'support_name' => 'Name',
            'company' => 'Company',
            'no_hp' => 'No Hp',
            'email' => 'Email',
            'support_position_id' => 'Position',
            'user_id' => 'User ID',
            'file' => 'Profile Picture'
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

    public function getProfilePicture($support_id){
        $model = Support::find()->where('support_id = :support_id', [':support_id' => $support_id])->one();
        if(is_null($model->image_path)){
            return '/uploads/profile_pictures/default_user.png';
        }
        else
        {
            return $model->image_path;    
        }
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

    public function deleteImage() {
        $image = getcwd() . "/" . $this->image_path;
        if (unlink($image)) {
            $this->image_path = null;
            $this->save();
            return true;
        }
        return false;
    }

    /*
        setter
    */

}
