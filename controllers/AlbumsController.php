<?php
namespace app\controllers;
 
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\HttpBasicAuth; 
use yii\filters\AccessControl;

 
class AlbumsController extends ActiveController
{
    public $modelClass = 'app\models\Albums';
    public $reservedParams = ['sort','q'];
    

    public function actions() {
        
        $actions = parent::actions();
        // переопределяем метод prepareDataProvider, который подготовит нам 
        //отсортированные данные
        $actions['index']['prepareDataProvider'] = [$this, 'indexDataProvider'];
        
        return $actions;
    
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

//проверка прав через RBAC
        $behaviors['access'] = [
                'class' => AccessControl::className(),
                'only' => ['delete'],
                'rules' => [
                    [
                        'allow' => true,
                       // 'roles' => ['admin'],
                        'matchCallback' => function ($rule, $action)
                        {
                            if(\Yii::$app->user->can('deleteAlbum'))
                                return true;
                        }
                    ],
                    
                ],
            
        ];

      return $behaviors;
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
                // есть среди атрибутов модели
              
                if (!in_array(strtolower($key), $this->reservedParams) 
                    && ArrayHelper::keyExists($key, $modelAttr, false)) {
                    $search[$key] = $value;
                }
            }
        }
        $searchByAttr['AlbumsSearch'] = $search;
        // для поиска пользуемся сгенерированным в Gii классом, 
        //которому передаем наш фильтрующий набор 
        $searchModel = new \app\models\AlbumsSearch(); 
        
        // возвращаем отфильтрованные данные
        return $searchModel->search($searchByAttr);     
    }

}