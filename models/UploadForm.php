<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model

{
    /**
     * @var UploadedFile
     */
    public $image;
    public $name;

    public function rules()
    {
        return [
            [['image'], 'image', 'extensions' => 'png, jpg'],
        ];
    }
    
}