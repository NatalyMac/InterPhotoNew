<?php

namespace app\models;

use Yii;

class AlbumImages extends \yii\db\ActiveRecord
{
   
    public static function tableName()
    {
        return 'album_images';
    }
    public function rules()
    {
        return [
            [[ 'image'], 'required'],
            [['album_id'], 'integer'],
            [['image'], 'string'],
            [['created_at'], 'safe'],
            [['album_id'], 'exist', 'skipOnError' => true, 'targetClass' => Albums::className(), 'targetAttribute' => ['album_id' => 'id']],
            [['album_id'], 'default', 'value' => function() {return \Yii::$app->request->queryParams['id'];}
            ],
        ];
    }

    public function fields() 
    {
    $fields = parent::fields();
    // because of the json worning, unset for working
    unset($fields['image']);

    return $fields;
    }
    
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'album_id' => 'Album ID',
            'image' => 'Image',
            'created_at' => 'Created At',
        ];
    }

    public function getAlbum()
    {
        return $this->hasOne(Albums::className(), ['id' => 'album_id']);
    }

    public function getOrderImages()
    {
        return $this->hasMany(OrderImages::className(), ['image_id' => 'id']);
    }
}
