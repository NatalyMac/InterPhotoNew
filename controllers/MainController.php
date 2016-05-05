<?php

namespace app\controllers;

use yii\base\ActionFilter;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\HttpBasicAuth; 
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;


class MainController extends ActiveController 
{
    public $modelClass          = null;
    public $modelName           = null;
    public $searchModelClass    = null;
    public $searchModelName     = null;
    public $linkedModelName     = null ;
    // $allowId is indicator to restrict index data by current user or alloewd items if it is requared by autorization rules 
    // available values 'id', 'user_id', 'albums'
    // when $allowId is 'albums' model Albums checks albums_id and user_id in the AlbumImages model 
    public $allowId             = null;
    public $reservedParams   = ['sort','q'];

    public $serializer = 'app\controllers\MySerializer';
    
    public function actions() 
    {   
        $actions = parent::actions();
        // method for filtering collection of models  
        $actions['index']['prepareDataProvider'] = [$this, 'indexDataProvider'];
        return $actions;
    
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        
        // user authentication
        $behaviors['authenticator'] = 
            [
                'class' => HttpBearerAuth::className(),
            ];
        // user autherization
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'except' => ['options'],
            // 'only' => ['create', 'update', 'delete','view','index', 'index-images'],
            'rules' => [
                [
                    'actions' => ['delete'],
                    'allow' => true,
                    'matchCallback' => function ($rule, $action)
                    {
                        if(\Yii::$app->user->can('delete'.$this->modelName))
                                return true;
                    }
                ],

                [
                    'actions' => ['update'],
                    'allow' => true,
                    'matchCallback' => function ($rule, $action)
                    {   
                        if(\Yii::$app->user->can('update'.$this->modelName))
                               return true;
                    }
                ],
                [
                    'actions' => ['create'],
                    'allow' => true,
                    'matchCallback' => function ($rule, $action)
                    {
                        if(\Yii::$app->user->can('create'.$this->modelName))
                            return true;
                    }
                ],
                [
                    'actions' => ['index'],
                    'allow' => true,
                    'matchCallback' => function ($rule, $action)
                    {  // $this->allowId = 'user_id';
                        if(\Yii::$app->user->can('index'.$this->modelName))
                            return true;
                    }
                ],
                [
                    'actions' => ['view'],
                    'allow' => true,
                    'matchCallback' => function ($rule, $action)
                    {
                        if(\Yii::$app->user->can('view'.$this->modelName))
                            return true;
                    }
                ],

                [
                    'actions' => ['index-'.strtolower($this->linkedModelName)],
                    'allow' => true,
                    'matchCallback' => function ($rule, $action)
                    { 
                        if(\Yii::$app->user->can('index'.$this->linkedModelName))
                            return true;
                    }
                ],
                /*
                [
                    'actions' => ['view-'.strtolower($this->linkedModelName)],
                    'allow' => true,
                    'matchCallback' => function ($rule, $action)
                    { 
                        if(\Yii::$app->user->can('view'.$this->linkedModelName))
                            return true;
                    }
                ],
                [
                    'actions' => ['create-'.strtolower($this->linkedModelName)],
                    'allow' => true,
                    'matchCallback' => function ($rule, $action)
                    { 
                        if(\Yii::$app->user->can('create'.$this->linkedModelName))
                            return true;
                    }
                ],
                [
                    'actions' => ['update-'.strtolower($this->linkedModelName)],
                    'allow' => true,
                    'matchCallback' => function ($rule, $action)
                    { 
                        if(\Yii::$app->user->can('update'.$this->linkedModelName))
                            return true;
                    }
                ],
                [
                    'actions' => ['delete-'.strtolower($this->linkedModelName)],
                    'allow' => true,
                    'matchCallback' => function ($rule, $action)
                    { 
                        if(\Yii::$app->user->can('delete'.$this->linkedModelNmae))
                            return true;
                    }
                ],
                */
            ],//rules
        ];
             return $behaviors;
    }
    

    public function indexDataProvider() 
    {
        $filter = $this->getFilterParams();
        //set key  as id or user_id (depending on model) => current user
        $filter[$this->allowId] = \Yii::$app->user->identity->id;
        $searchByAttr[$this->searchModelName] = $filter;
        $searchModel = new $this->searchModelClass();
            return $searchModel->search($searchByAttr);
           
    }
    
    public function getFilterParams()
    {
        $params = \Yii::$app->request->getQueryParams();
        $model = new $this->modelClass;
        $modelAttr = $model->attributes;
        
        // array of filters as key => value array from GET request
        $filter = [];
            if (!empty($params)) 
            {
                foreach ($params as $key => $value) 
                {
                    if(!is_scalar($key) or !is_scalar($value)) 
                        throw new BadRequestHttpException('400 Bad Request. Parameters are not scalar',400);
                    // not reserved words and is model attributes
                    if (!in_array(strtolower($key), $this->reservedParams) && ArrayHelper::keyExists($key, $modelAttr, false)) 
                        $filter[$key] = $value;
                }
            } 
        return $filter;
    }
}
