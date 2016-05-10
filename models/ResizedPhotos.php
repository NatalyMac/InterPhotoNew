<?php

namespace app\models;

use Yii;

class ResizedPhotos extends \yii\db\ActiveRecord
{
   
    public static function tableName()
    {
        return 'resized_photos';
    }

    public function rules()
    {
        return [
            [['status'], 'required'],
            [['image_id'], 'integer'],
            [['status', 'comment'], 'string'],
            [['size', 'origin'], 'string', 'max' => 50],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => AlbumImages::className(), 'targetAttribute' => ['image_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'size' => 'Size',
            'image_id' => 'Image ID',
            'status' => 'Status',
            'origin' => 'Origin',
        ];
    }

    public function getImage()
    {
        return $this->hasOne(AlbumImages::className(), ['id' => 'image_id']);
    }

}
