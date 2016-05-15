<?php

namespace app\models;

use Yii;

class ResizedPhotos extends \yii\db\ActiveRecord
{

    /**
     * This is the model class for table "resized_photos".
     *
     * @property string $status
     * @property integer $image_id
     * @property integer $id
     * @property string $size
     * @property string $origin
     * @property string $comment
     *
     * @property AlbumImages $image
     */

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resized_photos';
    }

    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(AlbumImages::className(), ['id' => 'image_id']);
    }

}
