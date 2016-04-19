<?php

namespace app\controllers;

use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\HttpBasicAuth; 
use yii\filters\AccessControl;
use yii\base\ActionFilter;
use app\components\AccessRule;
use app\models\Users; 
use app\models\Albums;

class AlbumImagesController extends ActiveController {

     public $modelClass  = '\app\models\AlbumImages';
}