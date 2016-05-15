<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "albums".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property integer $active
 * @property integer $created_at
 * @property integer $modified_at
 *
 * @property AlbumClients[] $albumClients
 * @property AlbumImages[] $albumImages
 * @property Users $user
 */
class Albums extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'albums';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['user_id', 'active'], 'integer'],
            [['created_at', 'modified_at'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['user_id'], 'default', 'value' => function () {
                return \Yii::$app->user->identity->id;
            }]
        ];
    }

    /**
     * @inheritdoc
     */
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbumClients()
    {
        return $this->hasMany(AlbumClients::className(), ['album_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbumImages()
    {
        return $this->hasMany(AlbumImages::className(), ['album_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }


    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'modified_at'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['modified_at'],
                ],
            ],
        ];
    }

    /**
     * @param $idUser
     * @return array
     */
    public static function getClientAlbums($idUser)
    {
        $albums = null;
        $i = 0;
        $clientAlbums = array();
        $albums = AlbumClients::find()
            ->select('album_id')
            ->where([
                'user_id' => $idUser,
            ])
            ->asArray()
            ->all();

        foreach ($albums as $album) {
            $clientAlbums[$i] = $album['album_id'];
            $i++;
        }
        return $clientAlbums;
    }

    /**
     * @param $id
     * @param $userId
     * @return array|null|\yii\db\ActiveRecord[]
     */
    public static function getAlbumAllow($id, $userId)
    {
        $album = null;
        $album = AlbumClients::find()
            ->where([
                'user_id' => $userId,
                'album_id' => $id,
            ])
            ->all();
        return $album;
    }

}

