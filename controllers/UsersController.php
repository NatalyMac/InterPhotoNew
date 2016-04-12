<?php

namespace app\controllers;

use app\models\Users; 
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\HttpBasicAuth; 
use yii\filters\AccessControl;
use app\controllers\components\AccessRule;




class UsersController extends ActiveController
{

   
    
    public $modelClass = 'app\models\Users';
    
    // отслеживаем в запросе зарезервированные слова
    public $reservedParams = ['sort','q'];
    
    public function actions() 
    {
        $actions = parent::actions();
        // переопределяем метод prepareDataProvider, который подготовит нам 
        //отсортированные данные
        $actions['index']['prepareDataProvider'] = [$this, 'indexDataProvider'];
            return $actions;
    
    }
    
    public function indexDataProvider() {
	 
        $params = \Yii::$app->request->queryParams;
        $model = new $this->modelClass;
      
        $modelAttr = $model->attributes;
        // здесь соберем фильтрующий набор ( 'key' => 'value' )
        // по условиям: не содержит зарезервированных слов, 
        // содержит только скалярные величины,
        // 'key' есть среди атрибутов модели
        $search = [];
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                // скалярность
                if(!is_scalar($key) or !is_scalar($value)) {
                    throw new BadRequestHttpException('Bad Request');
                }
                // есть среди атрибутов модели и не зарезервированные слова
              
                if (!in_array(strtolower($key), $this->reservedParams) 
                    && ArrayHelper::keyExists($key, $modelAttr, false)) {
                    $search[$key] = $value;
                }
            }
        }
        $searchByAttr['UsersSearch'] = $search;
        // для поиска пользуемся сгенерированным в Gii классом, 
        //которому передаем наш фильтрующий набор 
        $searchModel = new \app\models\UsersSearch(); 
        
        // возвращаем отфильтрованные данные
        return $searchModel->search($searchByAttr);     
    }
    

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                [
                'class' => HttpBasicAuth::className(),
                'auth' => function($username, $password)
                    {
                        $out = null;
                        $user = \app\models\Users::findByUsername($username);
                        if($user!=null) {
                            if($user->validatePassword($password)) $out = $user;
                        }
                        return $out;
                    }
                ],
               
                 'class' => HttpBearerAuth::className(),
            ]
        ];
      
       $behaviors['access'] = 
       // использовано два метода проверки
       // 1-й проверяем прямо здесь наши роли и действия в секции 'rules'
       // 2-й здесь задаем набор ролей и соответствующие действия, а проверку 
       // делаем в AccessRules

       [
            'class' => AccessControl::className(),
            // проверка роли залогиненного пользователя с заданными ролями в
            // правилах реализована в AccessRules class
            
            // раскомментить след строку, если проверка в классе AccessRules
            // а не в matchCallback        
            //'ruleConfig' => ['class' => AccessRules::className(),],

                'only' => ['create', 'update', 'delete'],
                'rules' => 
                   [
                
                    [
                    'actions' => ['create'],
                    'allow' => true,
                    'roles' => ['admin','photographer','client'],
                    
                    'matchCallback' => function ($rule, $action)
                    {
                    if (!\Yii::$app->user->getIsGuest() && 'admin' === \Yii::$app->user->identity->role) return true;
                    if (!\Yii::$app->user->getIsGuest() && 'photographer' === \Yii::$app->user->identity->role) return true;
                    if (!\Yii::$app->user->getIsGuest() && 'client' === \Yii::$app->user->identity->role) return true;
                    }
                
                    ],
                
                    [
                    'actions' => ['update'],
                    'allow' => true,
                    'roles' => ['admin'],
                    'matchCallback' => function ($rule, $action)
                    {
                    if (!\Yii::$app->user->getIsGuest() && 'admin' === \Yii::$app->user->identity->role) return true;
                    }
                    
                    ],
                
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['admin'],
                        'matchCallback' => function ($rule, $action)
                        {
                        if (!\Yii::$app->user->getIsGuest() && 'admin' === \Yii::$app->user->identity->role) return true;
                        }
                    ],
                  ],//rules
         ];
        
        return $behaviors;
    }

}

