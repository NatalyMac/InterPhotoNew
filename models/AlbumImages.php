<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;


class AlbumImages extends \yii\db\ActiveRecord
{
    /**
     * This is the model class for table "album_images".
     *
     * @property integer $id
     * @property integer $album_id
     * @property string $image
     * @property integer $created_at
     *
     * @property Albums $album
     * @property OrderImages[] $orderImages
     * @property ResizedPhotos[] $resizedPhotos
     */

    public $resized;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'album_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image'], 'required'],
            [['album_id'], 'integer'],
            [['image'], 'string', 'max' => 50],
            [['created_at'], 'safe'],
            [['album_id'], 'exist', 'skipOnError' => true, 'targetClass' => Albums::className(), 'targetAttribute' => ['album_id' => 'id']],
            [['album_id'], 'default', 'value' => function () {
                                                  return \Yii::$app->request->queryParams['id'];}
            ],
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
            'image' => 'Image',
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
    public function getOrderImages()
    {
        return $this->hasMany(OrderImages::className(), ['image_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResizedPhotos()
    {
        return $this->hasMany(ResizedPhotos::className(), ['image_id' => 'id']);
    }

    /**
     * @return array
     */
    public function extraFields()
    {
        return ['resizedPhotos'];
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
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (Albums::findOne($this->album_id))
                return true;
        } else {
            return false;
        }
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     * @return bool
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        foreach ($this->resized as $resizedPhotos) {
            $resizedPhotos->image_id = $this->id;

            if (!$resizedPhotos->save())
                return false;
        }
        return true;
    }
}
