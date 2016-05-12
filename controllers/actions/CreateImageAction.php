<?php
namespace app\controllers\actions;


use Yii;
use yii\rest\Action;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use app\models\UploadForm;
use app\models\AlbumImages;
use app\models\ResizedPhotos;
use yii\web\UploadedFile;


class CreateImageAction extends \yii\rest\Action
{
    public $uploadDir = 'upload/';
    
    public function run()
    {
        $model = new UploadForm();
        if (Yii::$app->request->isPost) 
            {
                if (!$model->imageFile = UploadedFile::getInstance($model, 'imageFile'))
                    throw new NotFoundHttpException('File is not choosen');
                        if (!$model->upload()) 
                            throw new NotFoundHttpException('File format is not correct'); 
            
            }
        $params = \Yii::$app->request->getQueryParams();
        $albumImage = new AlbumImages();
        $albumImage->image = $model->imageFile->name;
        $albumImage->album_id = $params['id'];
    
        $albumImage->resized[] =  new ResizedPhotos(['status'=>'new']);
        $albumImage->resized[] =  new ResizedPhotos(['status' =>'new']);

        if (!$albumImage->save())
            throw new ServerErrorHttpException('Failed to action for unknown reason. Check the id album');

    }
}   
