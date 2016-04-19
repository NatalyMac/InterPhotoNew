<?php
namespace app\controllers;
 
use app\models\Users; 
use app\models\Albums;
use app\controllers\auth\AuthorRule;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\filters\AccessControl;
use app\controllers\MainController;
 

class AlbumsController extends MainController
{
    public $modelClass  = '\app\models\Albums';
    public $searchAttr  = 'AlbumsSearch';
    public $searchModel = '\app\models\AlbumsSearch';
    public $authModel   = '\app\models\Users';
    public $nameModel   = '\app\models\Albums';


public function behaviors()
    {
        $behaviors = parent::behaviors();
       

//check Access RBAC
       $behaviors['access'] = [
                'class' => AccessControl::className(),
                'only' => ['create', 'update', 'delete','view','index', 'images'],
                'rules' => [
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action)
                        {
                            if(\Yii::$app->user->can('deleteAlbum'))
                                return true;
                        }
                    ],

                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action)
                        {   
                            if(\Yii::$app->user->can('updateAlbum'))
                               return true;
                        }
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action)
                        {
                            if(\Yii::$app->user->can('createAlbum'))
                                return true;
                        }
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action)
                        {  // $this->allowId = 'user_id';
                            if(\Yii::$app->user->can('indexAlbum'))
                                return true;
                        }
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action)
                        {
                            if(\Yii::$app->user->can('viewAlbum'))
                                return true;
                        }
                    ],
                    [
                        'actions' => ['images'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action)
                        {
                            if(\Yii::$app->user->can('indexImages'))
                                return true;
                        }
                    ],

                ],
            
        ];
       

    return $behaviors;
   }
   
    public function actionImages()
    {
        $params = \Yii::$app->request->queryParams;
        $query = Albums::findOne($params['id']);
            return $query->albumImages;
    }
}