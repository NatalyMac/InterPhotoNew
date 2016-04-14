<?php

namespace app\controllers;

use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\HttpBasicAuth; 
use yii\filters\AccessControl;

use app\components\AccessRule;

class MainController extends ActiveController {


    public $reservedParams = ['sort','q'];
    //полное имя класса модели, используемой для поиска, '\app\models\UsersSearch'
    public $searchModel = Null;
    //имя атрибута поиска = имя модели поиска, 'UsersSearch'
    public $searchAttr = Null;
    // полное имя модели, которая используется для хранения пользователей
    // '\app\models\Users'
    public $authModel = Null;
    //имя модели для findNeedModel
    public $nameModel = Null;

    
    //запрос с фильтром по атрибутам типа GET controller?attribute='...'
    // переопределяем метод prepareDataProvider, который подготовит нам 
    //отсортированные данные
    public function actions() 
    {   
        $actions = parent::actions();

        // переопределяем метод prepareDataProvider, который подготовит нам 
        //отсортированные данные
        $actions['index']['prepareDataProvider'] = [$this, 'indexDataProvider'];
            return $actions;
    
    }
    
    // данные для поиска -> в модель -> отфильтрованные данные из модели
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
        $searchByAttr[$this->searchAttr] = $search;
        // для поиска пользуемся сгенерированным в Gii классом, 
        //которому передаем наш фильтрующий набор 
        $searchModel = new $this->searchModel();
        
        // возвращаем отфильтрованные данные
            return $searchModel->search($searchByAttr);     
    }


// аутентификация пользователей

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
                        $authModel=$this->authModel;
                        $user = $authModel::findByUsername($username);
                        
                        if($user!=null) {
                            if($user->validatePassword($password)) $out = $user;
                        }
                        return $out;
                    }
                ],
               
                 'class' => HttpBearerAuth::className(),
            ]
        ];
      return $behaviors; 
    }

// хелперы
    public function findNeedModel($id)
    {
        $nameModel = $this->nameModel;
        if (($model = $nameModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('404 The requested page does not exist.');
        }
    }   
}

