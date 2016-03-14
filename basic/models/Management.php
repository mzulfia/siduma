<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "management".
 *
 * @property integer $management_id
 * @property string $mgt_name
 * @property string $position
 * @property string $no_hp
 * @property string $email
 * @property string $image_path
 */
class Management extends \yii\db\ActiveRecord
{
    const IMAGE_PLACEHOLDER = '/uploads/profile_pictures/default_user.png';
    
    public $file;

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
            [['user_id'], 'integer'],
            [['mgt_name', 'position', 'no_hp', 'email'], 'string', 'max' => 50],
            [['image_path'], 'string', 'max' => 255],
            [['file'], 'file', 'maxSize'=>'200000'],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, png'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'management_id' => 'Management ID',
            'mgt_name' => 'Management Name',
            'position' => 'Position',
            'no_hp' => 'No Hp',
            'email' => 'Email',
            'image_path' => 'Image Path',
        ];
    }

    /*
        get the relations
    */

    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }

    /*
        getter
    */

    public function getProfilePicture($id){
        $model = Management::find()->where('management_id = :id', [':id' => $id])->one();
        if(is_null($model->image_path)){
            return Management::IMAGE_PLACEHOLDER;
        }
        else
        {
            return $model->image_path;    
        }
    }

    public function getName($id){
        $model = Management::find()->where('management_id = :id', [':id' => $id])->one();
        if(!empty($model->mgt_name)){
           return $model->mgt_name;
        }
        else
        {
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
}
