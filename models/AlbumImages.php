<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\models\ResizedPhotos;


class AlbumImages extends \yii\db\ActiveRecord
{
    public $resized;
   
    public static function tableName()
    {
        return 'album_images';
    }
    public function rules()
    {
        return [
            [['image'], 'required'],
            [['album_id'], 'integer'],
            [['image'], 'string', 'max' => 50],
            [['created_at'], 'safe'],
            [['album_id'], 'exist', 'skipOnError' => true, 'targetClass' => Albums::className(), 'targetAttribute' => ['album_id' => 'id']],
            [['album_id'], 'default', 'value' => function() {return \Yii::$app->request->queryParams['id'];}
            ],
        ];
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
    

    public function getResizedPhotos()
           {
               return $this->hasMany(ResizedPhotos::className(), ['image_id' => 'id']);
           }

    public function extraFields()
    {
    return ['resizedPhotos'];
    }

    public function behaviors()
    {
        return [
              
               [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }
    

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) 
        {
            if (Albums::findOne($this->album_id))
                return true;
        } else {
           return false;
        }   
    }


    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert,$changedAttributes);      
            foreach($this->resized as $resizedPhotos) 
            {
                $resizedPhotos->image_id = $this->id;
                
                if (!$resizedPhotos->save()) 
                    return false;
            }
        return true;
    }
}
