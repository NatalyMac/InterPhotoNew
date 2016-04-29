<?php

namespace app\controllers;

use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
//use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
//use yii\filters\auth\CompositeAuth;
//use yii\filters\auth\HttpBearerAuth;
//e yii\filters\auth\HttpBasicAuth; 
use yii\filters\AccessControl;
use yii\base\ActionFilter;
//use app\components\AccessRule;
use app\models\Users; 
use app\models\Albums;

class AlbumImagesController extends MainController {

    public $modelClass  = '\app\models\AlbumImages';
  
    public $searchAttr  = 'AlbumImagesSearch';
    public $searchModel = '\app\models\AlbumImagesSearch';
    public $authModel   = '\app\models\Users';
    public $allowId     =  null;
}

public function actionIndexImages()
{
    /*if ($images = Albums::findOne(\Yii::$app->request->queryParams['id']))
    {
        return $images->albumImages;
    } else {  
        throw new NotFoundHttpException($message = "Object not found: " . \Yii::$app->request->queryParams['id']); 
            }*/
            return 'hello';
}