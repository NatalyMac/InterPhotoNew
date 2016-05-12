<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model

{
    
    public $image;
    public $name;
    public $imageFile;
    public $uploadDir = 'upload/';

    public function rules()
    {
        return [
             [['imageFile'], 'image'],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs($this->uploadDir.$this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }

}
