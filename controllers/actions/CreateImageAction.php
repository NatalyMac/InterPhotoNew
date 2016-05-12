<?php
namespace app\controllers\actions;


use Yii;
use yii\rest\Action;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use app\models\UploadForm;
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
                throw new ServerErrorHttpException('Failed to action for unknown reason.');
          
            $params = \Yii::$app->request->getQueryParams();
            $albumImage = new AlbumImages();
            $albumImage->image = $model->name;
    
            $albumImage->resized[] =  new ResizedPhotos(['status'=>'new']);
            $albumImage->resized[] =  new ResizedPhotos(['status' =>'new']);
                
            if (!$albumImage->save()) 
              throw new ServerErrorHttpException('Failed to action for unknown reason.');
         
        }
        return;
       }
}

