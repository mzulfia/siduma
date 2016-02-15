<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "guest".
 *
 * @property integer $guest_id
 * @property string $guest_nip
 * @property string $guest_name
 * @property string $importance
 * @property string $in_time
 * @property string $out_time
 */
class Guest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'guest';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['importance'], 'string'],
            [['in_time', 'out_time'], 'safe'],
            [['guest_nip', 'guest_name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'guest_id' => 'Guest ID',
            'guest_nip' => 'NIP',
            'guest_name' => 'Nama',
            'importance' => 'Kepentingan',
            'in_time' => 'Waktu Masuk',
            'out_time' => 'Waktu Keluar',
        ];
    }
}
