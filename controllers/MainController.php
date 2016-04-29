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

    public $reservedParams   = ['sort','q'];
    // full name of model for searching, '\app\models\UsersSearch'
    // public $searchModel     = null;
    // name of atrr for searching  = name model, 'UsersSearch'
    //public $searchAttr       = null;
    // full name of users model '\app\models\Users'
    // public $authModel        = null;
    // name model for AuthorRule
    //public $nameModel        = null;
    // filter for indexDataProvider or id or user_id, depending of models
    public $allowId          = null;

    public function actions() 
    {   
        $actions = parent::actions();
        // method for filtering collection of models  
        $actions['index']['prepareDataProvider'] = [$this, 'indexDataProvider'];
        return $actions;
    
    }

    // user authentication
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = 
           [
           /*
            'class' => CompositeAuth::className(),
            'authMethods' => 
            [
                [
                'class' => HttpBasicAuth::className(),
                'auth' => function($username, $password)
                        {  
                          $authUser = $this->validateUser($username, $password);
                                return $authUser;
                        }
                ],
                */
                'class' => HttpBearerAuth::className(),
                //],
            ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
           // 'only' => ['create', 'update', 'delete','view','index', 'index-images'],
            'rules' => [
                [
                    'actions' => ['delete'],
                    'allow' => true,
                    'matchCallback' => function ($rule, $action)
                    {
                        if(\Yii::$app->user->can('delete'.$this->model))
                                return true;
                    }
                ],

                [
                    'actions' => ['update'],
                    'allow' => true,
                    'matchCallback' => function ($rule, $action)
                    {   
                        if(\Yii::$app->user->can('update'.$this->model))
                               return true;
                    }
                ],
                [
                    'actions' => ['create'],
                    'allow' => true,
                    'matchCallback' => function ($rule, $action)
                    {
                        if(\Yii::$app->user->can('create'.$this->model))
                            return true;
                    }
                ],
                [
                    'actions' => ['index'],
                    'allow' => true,
                    'matchCallback' => function ($rule, $action)
                    {  // $this->allowId = 'user_id';
                        if(\Yii::$app->user->can('index'.$this->model))
                            return true;
                    }
                ],
                [
                    'actions' => ['view'],
                    'allow' => true,
                    'matchCallback' => function ($rule, $action)
                    {
                        if(\Yii::$app->user->can('view'.$this->model))
                            return true;
                    }
                ],
                [
                    'actions' => ['index-'.strtolower($this->linkedModel)],
                    'allow' => true,
                    'matchCallback' => function ($rule, $action)
                    { 
                        if(\Yii::$app->user->can('index'.$this->linkedModel))
                            return true;
                    }
                ],

                ],
            
        ];
    return $behaviors;
}
    
    // helpers
    public function getFilterParams()
    {
        $params = \Yii::$app->request->queryParams;
        $model = new $this->modelClass;
        $modelAttr = $model->attributes;
        
        // filter key => value array from GET request
        $filter = [];
            if (!empty($params)) 
            {
                foreach ($params as $key => $value) 
                {
                    if(!is_scalar($key) or !is_scalar($value)) {
                        throw new BadRequestHttpException('400 Bad Request',400);
                    }
                    // not reserved words and model attributes
                    if (!in_array(strtolower($key), $this->reservedParams) 
                        && ArrayHelper::keyExists($key, $modelAttr, false)) 
                        $filter[$key] = $value;
                }
            } 
        return $filter;
    }

    public function indexDataProvider() 
    {
        $filter = $this->getFilterParams();
        //set key  as id or user_id (depending on model) => current user
        $filter[$this->allowId] = \Yii::$app->user->identity->id;
                 
        $searchByAttr[$this->searchAttr] = $filter;
            
        $searchModel = new $this->searchModel();
        
            return $searchModel->search($searchByAttr);
           
    }
  /*  
    public function validateUser($username, $password)
    {
        $authUser = null;
        $authModel=$this->authModel;
        $user = $authModel::findByUsername($username);
                       
        if($user!=null and $password!=null) {
            if($user->validatePassword($password)) {
               $authUser = $user;
               $this->setToken($authUser);
            }
            return $authUser;
        }   
    }
    
    // set and send token for validated user
    public function setToken($authUser)
    {
        if (!$authUser) throw new  BadRequestHttpException('Bad Request',400);
         
        $authUser->generateAccessToken();
        
        $authHeader = $authUser->access_token;
        $response = \Yii::$app->response;
        $response->getHeaders()->set('Autorization', 'Bearer '.$authHeader);
    }
*/
    public function findModelAuthorRule($id)
    {
        $nameModel = $this->modelClass;
        if (($model = $nameModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('404 The requested page does not exist.', 404);
        }
    }
}