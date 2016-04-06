<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pln_pic".
 *
 * @property integer $pln_pic_id
 * @property string $pic_name
 * @property string $email
 * @property string $no_hp
 * @property string $image_path
 *
 * @property PicArea[] $picAreas
 */
class PlnPic extends \yii\db\ActiveRecord
{
    const IMAGE_PLACEHOLDER = '/uploads/profile_pictures/default_user.png';

    public $file;
    public $pic_area; 
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pln_pic';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pic_name', 'email', 'no_hp', 'file'], 'required'],
            [['pic_name', 'email', 'no_hp'], 'string', 'max' => 50],
            [['image_path'], 'string', 'max' => 255],
            [['file'], 'file', 'maxSize'=>'200000'],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, png'],
            [['pic_area'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pic_name' => 'PIC Name',
            'email' => 'Email',
            'no_hp' => 'No Hp',
            'image_path' => 'Image Path',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPicAreas()
    {
        return $this->hasMany(PicArea::className(), ['pln_pic_id' => 'pln_pic_id']);
    }

    /*
        getter
    */

    public function getProfilePicture($id){
        $model = PlnPic::find()->where('pln_pic_id = :id', [':id' => $id])->one();
        if(is_null($model->image_path)){
            return PlnPic::IMAGE_PLACEHOLDER;
        }
        else
        {
            return $model->image_path;    
        }
    }


    public function getServiceInCharge($id){
        $model = PicArea::find()->where('support_id = :id', [':id' => $id])->all();
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

    public function deleteImage() {
       if(!empty($this->image_path)){
            $image = getcwd() . "/" . $this->image_path;
            if(file_exists($image)){
                if (unlink($image)) {
                    $this->image_path = null;
                    $this->save();
                    return true;
                }    
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    /*
        setter
    */

     public function afterSave($insert, $changedAttributes){
        if(!empty($this->pic_area)){
            \Yii::$app->db->createCommand()->delete('pic_area', 'pln_pic_id = '.(int) $this->pln_pic_id)->execute(); //Delete existing value
            foreach ($this->pic_area  as $id) { //Write new values
                $sa = new PicArea();
                $sa->pln_pic_id = $this->pln_pic_id;
                $sa->service_family_id = $id;
                $sa->save();
            }
        }
    }
}
