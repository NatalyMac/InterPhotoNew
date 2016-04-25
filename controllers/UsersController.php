<?php

namespace app\controllers;

use app\models\Users; 
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\filters\AccessControl;
use app\controllers\MainController;
use yii\web\NotFoundHttpException;

class UsersController extends MainController
{
    public $modelClass  = '\app\models\Users';
    public $searchAttr  = 'UsersSearch';
    public $searchModel = '\app\models\UsersSearch';
    public $authModel   = '\app\models\Users';
    public $allowId     =  null;
    
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        
        // ACF filter for checking user access
        $behaviors['access'] = 
           [
            'class' => AccessControl::className(),
            // check roles AccessRules
            'ruleConfig' => ['class' => AccessRules::className(),],
            'only' => ['create', 'update', 'delete','view','index'],
                'rules' => 
                [
                    [
                    'actions' => ['create'],
                    'allow' => true,
                    'roles' => ['admin','photographer','client'],
                    ],
                    [
                    'actions' => ['update','view',],
                    'allow' => true,
                    'roles' => ['admin', 'photographer','client',],
                    'matchCallback' => function ($rule, $action)
                        {
                            if ($this->isAdmin() or $this->isOwner())
                                return true;
                        }
                    ],
                    [
                    'actions' => ['index'],
                    'allow' => true,
                    'roles' => ['photographer','client','admin'],
                    'matchCallback' => function ($rule, $action)
                        {
                            if ($this->isAdmin()) 
                                   return true;
                            if (!$this->isAdmin() and 
                               (isset(\Yii::$app->request->queryParams["id"])))
                                   return false;
                            $this->allowId = 'id';
                                   return true;
                        }
                    ], 
                    [
                        'actions' => ['delete',],
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

