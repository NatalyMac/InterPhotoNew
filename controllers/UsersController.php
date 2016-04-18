<?php

namespace app\controllers;

use app\models\Users; 
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
//use yii\filters\auth\CompositeAuth;
//use yii\filters\auth\HttpBearerAuth;
//use yii\filters\auth\HttpBasicAuth; 
use yii\filters\AccessControl;
use app\controllers\MainController;

class UsersController extends MainController
{
    public $modelClass  = '\app\models\Users';

    public $searchAttr  = 'UsersSearch';
    public $searchModel = '\app\models\UsersSearch';
    public $authModel   = '\app\models\Users';

    
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = 
       // использовано два метода проверки
       // 1-й проверяем прямо здесь наши роли и действия в секции 'rules'
       // 2-й здесь задаем набор ролей и соответствующие действия, а проверку 
       // делаем в AccessRules

       [
            'class' => AccessControl::className(),
            // проверка роли залогиненного пользователя с заданными ролями в
            // правилах реализована в AccessRules class
                
             'ruleConfig' => ['class' => AccessRules::className(),],

                'only' => ['create', 'update', 'delete','view'],
                'rules' => 
                   [
                
                    [
                    'actions' => ['create'],
                    'allow' => true,
                    'roles' => ['admin','photographer','client'],
                    ],
            
                    [
                    'actions' => ['update','view'],
                    'allow' => true,
                    'roles' => ['admin', 'photographer','client'],
                    
                    'matchCallback' => function ($rule, $action)
                    {
                    if ($this->isAdmin() or $this->isOwner())
                        return true;
                    }
                    ],
                
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['admin'],
                       
                    ],
                  ],//rules
         ];
        
                return $behaviors;
    }

    //хелперы

    public function isAdmin()
    {
         if  (\Yii::$app->user->identity->role ==='admin')
                        return true;
    }

    public function isOwner()
    {
        if ((int) \Yii::$app->user->identity->id === (int) \Yii::$app->request->queryParams['id'])
                        return true;
    }

}

