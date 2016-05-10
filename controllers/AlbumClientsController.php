<?php

namespace app\controllers;

use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth; 
use app\models\Users; 
use app\controllers\MainController;
use app\controllers\auth\LoginAction;

class AlbumClientsController extends MainController
{
    public $modelClass   = '\app\models\AlbumClients';
   // public $modelName    = 'AlbumClients';
    //public $searchModelClass  = ;

/*
     public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'except' => ['options'],
            // 'only' => ['create', 'update', 'delete','view','index', 'index-images'],
            'rules' => [
*/

  public function actionIndex()
    {
    	var_dump('hhhh');
        return parent::actionIndex();
    }

}
   