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
        //var_dump($actions['index']['prepareDataProvider']);
        
        // переопределяем для вывода по дополнительному запросу списка связанных с заданным id
        // заданной модели записей, например, users/22/?albums
        $actions['view']['findModel']= [$this, 'viewfindModel'];    

            return $actions;
    
    }
    
    public function viewFindModel() 
    {
        $params = \Yii::$app->request->queryParams;
        $search = [];
        if (!empty($params)) 
           {
            foreach ($params as $key => $value) 
                {
                // скалярность
                if(!is_scalar($key) or !is_scalar($value)) {
                    throw new BadRequestHttpException('400 Bad Request', 400);
                }
                // не зарезервированные слова
                if (!in_array(strtolower($key), $this->reservedParams)) 
                    $search[$key] = $value;
                }
            }   
            $searchModel = new $this->searchModel();
                return $searchModel->searchLinkItems($search);
    }


    // данные для поиска -> в модель -> отфильтрованные данные из модели
    public function indexDataProvider() 
    {
	 
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
                    throw new BadRequestHttpException('400 Bad Request',400);
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
                        $authUser = $this->validateUser($username, $password);
                        // раскомментить для работы
                       // $this -> setToken($authUser);
                            return $authUser;
                    }
                
               ],
                
               'class' => HttpBearerAuth::className(),
             ],
        ];
      return $behaviors; 
    }

    public function beforeAction($action)
        {
         // your custom code here, if you want the code to run before action filters,
         // wich are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl
    
            if (!parent::beforeAction($action)) {
                return false;
            }
    
         // other custom code here
     
                return true; // or false to not run the action
    }
    
    // генерируем токен для каждого экшена
    public function afterAction($action, $result)
        {
            $result = parent::afterAction($action, $result);
            // генерация токена после каждого запроса
            // расскоментить
            // $authUser = \Yii::$app->user->identity;
            // $this->setToken($authUser);
            // your custom code here
        return $result;
    }

    // хелперы
    // модель для author rule в rbac
    public function findNeededModel($id)
    {
        $nameModel = $this->nameModel;
        if (($model = $nameModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('404 The requested page does not exist.', 404);
        }
    }
    
    //проверка имени пароля, возврат объект юзера
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
    
    // генерируем токен для юзера, что прошел проверку
    public function setToken($authUser)
    {
        if (!$authUser) throw new  BadRequestHttpException('Bad Request',400);
         
        $authUser->generateAccessToken();
        $authHeader = $authUser->access_token;
        $response = \Yii::$app->response;
        $response->getHeaders()->set('Autorization', 'Bearer '.$authHeader);
    }
}