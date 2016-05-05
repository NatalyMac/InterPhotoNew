<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "album_clients".
 *
 * @property integer $id
 * @property integer $album_id
 * @property integer $user_id
 * @property string $access
 * @property string $created_at
 *
 * @property Albums $album
 * @property Users $user
 */
class AlbumClients extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'album_clients';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['album_id', 'user_id'], 'required'],
            [['album_id', 'user_id'], 'integer'],
            [['access'], 'string'],
            [['created_at'], 'safe'],
            [['album_id'], 'exist', 'skipOnError' => true, 'targetClass' => Albums::className(), 'targetAttribute' => ['album_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'album_id' => 'Album ID',
            'user_id' => 'User ID',
            'access' => 'Access',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbum()
    {
        return $this->hasOne(Albums::className(), ['id' => 'album_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
