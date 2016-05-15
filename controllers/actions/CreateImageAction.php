<?php
namespace app\controllers\actions;


use Yii;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use app\models\UploadForm;
use app\models\AlbumImages;
use app\models\ResizedPhotos;
use yii\web\UploadedFile;


class CreateImageAction extends \yii\rest\Action
{
    public $uploadDir = 'upload/';

    /**
     * Uploads image, makes records in the table and saves on the disk
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function run()
    {
        $nameSalt = (string)time();
        $model = new UploadForm();
        if (Yii::$app->request->isPost) {
            if (!$model->imageFile = UploadedFile::getInstance($model, 'imageFile'))
                throw new NotFoundHttpException('File is not choosen');
            if (!$model->upload($nameSalt))
                throw new NotFoundHttpException('File format is not correct');

        }
        $params = \Yii::$app->request->getQueryParams();
        $albumImage = new AlbumImages();
        
        AlbumImages::getDb()->transaction(function($db) use ($albumImage, $model, $nameSalt, $params) {
        $albumImage->image = $model->imageFile->baseName . '_' . $nameSalt. '.' .$model->imageFile->extension;
        $albumImage->album_id = $params['id'];
        $albumImage->resized[] = new ResizedPhotos(['status' => 'new']);
        $albumImage->resized[] = new ResizedPhotos(['status' => 'new']);
        $albumImage->save();
        });

        //if (!$albumImage->save())
        //   throw new ServerErrorHttpException('Failed to action for unknown reason. Check the id album');

    }
}   
