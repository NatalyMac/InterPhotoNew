<?php
namespace app\models;

use yii\base\Model;

class UploadForm extends Model

{
    /**
     * This is the model class for Uploading form.
     *
     * @property string $image
     * @property string $name
     * @property string $imageFile
     */

    public $imageFile;
    public $uploadDir = 'upload/';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['imageFile'], 'image'],
        ];
    }

    /**
     * saves uploaded file on the disk
     * @return boolean
     */
    public function upload($nameSalt)
    {
        if ($this->validate()) {
            $this->imageFile->saveAs($this->uploadDir . $this->imageFile->baseName . '_' . $nameSalt . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }

}
