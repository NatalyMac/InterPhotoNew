<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\behaviors\BlameableBehavior;
use \app\models\AlbumClients;


class Albums extends \yii\db\ActiveRecord
{
   
    public static function tableName()
    {
        return 'albums';
    }

   
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['user_id', 'active'], 'integer'],
            [['created_at', 'modified_at'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['user_id'], 'default', 'value' => function() { return  \Yii::$app->user->identity->id;}]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'active' => 'Active',
            'created_at' => 'Created At',
            'modified_at' => 'Modified At',
        ];
    }

    public function extraFields()
    {
    return ['albumImages'];
    }

    //return \yii\db\ActiveQuery
    public function getAlbumClients()
    {
        return $this->hasMany(AlbumClients::className(), ['album_id' => 'id']);
    }

    //return \yii\db\ActiveQuery
    public function getAlbumImages()
    {
        return $this->hasMany(AlbumImages::className(), ['album_id' => 'id']);
    }

    //return \yii\db\ActiveQuery
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
    
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors ['createdBy'] = 
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => $this->user_id,
                'updatedByAttribute' => $this->user_id,
                
            ];
        return $behaviors;
    }

    public static function getClientAlbums($idUser)
    {
        $albums = null;
        $i = 0;
        $clientAlbums = array ();
        $albums = AlbumClients::find()
              -> select ('album_id')
              -> where ([
                'user_id' => $idUser,
                ])
              ->asArray()
              ->all();
        
        foreach ($albums as $album)
        {
            $clientAlbums[$i] = $album['album_id'];
            $i++;
        }
            return $clientAlbums;
    }

    public static function getClientAlbum($id, $idUser)
    {
        $album = null;
        $album = AlbumClients::find()
              -> where ([
                'user_id' => $idUser,
                'album_id' =>$id,
                ])
              ->all();
            return $album;
    }


}

