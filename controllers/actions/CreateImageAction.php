<?php
namespace app\controllers\actions;


use Yii;
use yii\web\ServerErrorHttpException;
use yii\rest\Action;
use yii\web\UnprocessableEntityHttpException;
use yii\validators\EmailValidator;
use app\models\ResetPass;
use yii\swiftmailer\Mailer;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use app\models\UploadForm;
use yii\web\UploadedFile;
use app\models\AlbumImages;
use app\models\ResizedPhotos;



class CreateImageAction extends \yii\rest\Action
{
    public $uploadDir = 'upload/';
    
    public function run()
      {
        $model = new UploadForm();
        if (! $_FILES) 
          throw new NotFoundHttpException('File is not choosen. Please choose the file.');

        $uploadImage = $_FILES['image'];
        $tmpName = $uploadImage['tmp_name'];
    
        $fh = fopen($tmpName, 'r');
        $imgData = fread($fh, filesize($tmpName));
        fclose($fh);
        
        $model->image = $imgData;
        $model->name = $uploadImage['name'];
     
        if ($model->validate())
        {
            if (!move_uploaded_file($tmpName, $this->uploadDir.$model->name))
                ServerErrorHttpException('Failed to action for unknown reason.');
          
            $params = \Yii::$app->request->getQueryParams();
            $albumImage = new AlbumImages();
            $albumImage->image = $model->name;
            
            $resizedPhoto100 = new ResizedPhotos(['status'=>'new']);
            $resizedPhoto400 = new ResizedPhotos(['status' =>'new']);
    
            $albumImage->resized[] =  $resizedPhoto100;
            $albumImage->resized[] =  $resizedPhoto400;
                
            if (!$albumImage->save()) 
              throw new ServerErrorHttpException('Failed to action for unknown reason.');
         
        }
        return;
       }
}

