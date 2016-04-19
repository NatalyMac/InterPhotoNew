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


class MainController extends ActiveController 
{

    public $reservedParams   = ['sort','q'];
    // full name of model for searching, '\app\models\UsersSearch'
    public $searchModel     = null;
    // name of atrr for searching  = name model, 'UsersSearch'
    public $searchAttr       = null;
    // full name of users model '\app\models\Users'
    public $authModel        = null;
    // name model for AuthorRule
    public $nameModel        = null;
    // filter for indexDataProvider or id or user_id, depending of models
    public $allowId          = null;

    public function actions() 
    {   
        $actions = parent::actions();
        // method for filtering collection of models  
        $actions['index']['prepareDataProvider'] = [$this, 'indexDataProvider'];
        return $actions;
    
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

    // user authentication
    public function behaviors()
    {
            $behaviors = parent::behaviors();

            $behaviors['authenticator'] = 
            [
                'class' => CompositeAuth::className(),
                'authMethods' => 
                [
                    [
                        'class' => HttpBasicAuth::className(),
                        'auth' => function($username, $password)
                            {  
                                $authUser = $this->validateUser($username, $password);
                                // uncomment for work
                                // $this -> setToken($authUser);
                                    return $authUser;
                            }
                    ],
                
                'class' => HttpBearerAuth::className(),
                ],
            ];
            return $behaviors; 
    }

    // new token after every action
    public function afterAction($action, $result)
    {
            $result = parent::afterAction($action, $result);
            // uncomment for work
            // $authUser = \Yii::$app->user->identity;
            // $this->setToken($authUser);
        return $result;
    }

    // helpers
    // model for author rule rbac
    public function findModelAuthorRule($id)
    {
        $nameModel = $this->nameModel;
        if (($model = $nameModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('404 The requested page does not exist.', 404);
        }
    }
    
    public function validateUser($username, $password)
    {
        $authUser = null;
        $authModel=$this->authModel;
        $user = $authModel::findByUsername($username);
                       
        if($user!=null and $password!=null) {
            if($user->validatePassword($password)) $authUser = $user;
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
}