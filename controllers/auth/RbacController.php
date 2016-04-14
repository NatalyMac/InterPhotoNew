<?php

namespace app\controllers\auth;

use Yii;
use app\models\auth\AuthItem;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RbacController implements the CRUD actions for AuthItem model.
 */
class RbacController extends Controller
{
    /**
     * @inheritdoc
     */
    /*public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
*/
    /**
     * Lists all AuthItem models.
     * @return mixed
     */
    // создаем разрешения
    public function actionAssignment()
    {
       $auth = Yii::$app->authManager;
       $photographer = $auth->createRole('photographer');
       $admin = $auth->createRole('admin');
       
       // здесь привязка жесткая, нужно вынести установку роли и разрешения в метод 
       // ?????
       // пример
       /*
        $auth = Yii::$app->authManager;
        $authorRole = $auth->getRole('author');
        $auth->assign($authorRole, $user->getId());
        */ 

        $auth->assign($photographer, 22);
        $auth->assign($photographer, 23);
        $auth->assign($admin, 13);

    }
    
    public function actionCreate_rule_view()
    {
        $auth = Yii::$app->authManager;

        // add the rule
        $rule = new \app\controllers\auth\AuthorRule;
        //$auth->add($rule);

        // добавляем разрешение "updateOwnPost" и привязываем к нему правило.
        $viewOwnAlbum = $auth->createPermission('viewOwnAlbum');
        $viewOwnAlbum->description = 'View own album';
        $viewOwnAlbum->ruleName = $rule->name;
        $auth->add($viewOwnAlbum);

        $viewAlbum = $auth->createPermission('viewAlbum');
        // "updateOwnPost" будет использоваться из "updatePost"
        $auth->addChild($viewOwnAlbum, $viewAlbum);
        // проверить в таблице item_child photograper -> udateAlbum
        // удалить, иначе нет правильного наследования или в ролях коммент
        $photographer = $auth->createPermission('photographer');
        // разрешаем "автору" обновлять его посты
        $auth->addChild($photographer, $viewOwnAlbum);

    }


    public function actionCreate_rule_udate()
    {
        $auth = Yii::$app->authManager;

        // add the rule
        $rule = new \app\controllers\auth\AuthorRule;
        $auth->add($rule);

        // добавляем разрешение "updateOwnPost" и привязываем к нему правило.
        $updateOwnAlbum = $auth->createPermission('updateOwnAlbum');
        $updateOwnAlbum->description = 'Update own album';
        $updateOwnAlbum->ruleName = $rule->name;
        $auth->add($updateOwnAlbum);

        $updateAlbum = $auth->createPermission('updateAlbum');
        // "updateOwnPost" будет использоваться из "updatePost"
        $auth->addChild($updateOwnAlbum, $updateAlbum);
        // проверить в таблице item_child photograper -> udateAlbum
        // удалить, иначе нет правильного наследования или в ролях коммент
        $photographer = $auth->createPermission('photographer');
        // разрешаем "автору" обновлять его посты
        $auth->addChild($photographer, $updateOwnAlbum);

    }


    public function actionCreate_role()    
    {
        $auth = Yii::$app->authManager;
        // photographer -> index, create, view, update album
        // admin -> photographer and delete -> index, create, view, update, delete 
        //album
        $indexAlbum = $auth->createPermission('indexAlbum');
        $viewAlbum = $auth->createPermission('viewAlbum');
        $createAlbum = $auth->createPermission('createAlbum');
        $updateAlbum = $auth->createPermission('updateAlbum');

        $photographer = $auth->createRole('photographer');
        $auth->add($photographer);

        $auth->addChild($photographer, $indexAlbum);
        $auth->addChild($photographer, $createAlbum);
        $auth->addChild($photographer, $viewAlbum);
        //$auth->addChild($photographer, $updateAlbum);

        $deleteAlbum = $auth->createPermission('deleteAlbum');
        $admin = $auth->createRole('admin');
        $auth->add($admin);
    
        $auth->addChild($admin, $deleteAlbum);
        $auth->addChild($admin, $photographer);

    }

    public function actionCreate_permission()
    {
        $auth = Yii::$app->authManager;
        //добавляем разрешение "indexAlbum"
        $indexAlbum = $auth->createPermission('indexAlbum');
        $indexAlbum->description = 'Index an album';
        $auth->add($indexAlbum);

        // добавляем разрешение "viewAlbum"
        $viewAlbum = $auth->createPermission('viewAlbum');
        $viewAlbum->description = 'View album';
        $auth->add($viewAlbum);
        
        // добавляем разрешение "createAlbum"
        $createAlbum = $auth->createPermission('createAlbum');
        $createAlbum->description = 'Create an album';
        $auth->add($createAlbum);

        // добавляем разрешение "updateAlbum"
        $updateAlbum = $auth->createPermission('updateAlbum');
        $updateAlbum->description = 'Update album';
        $auth->add($updateAlbum);

        // добавляем разрешение "deleteAlbum"
        $deleteAlbum = $auth->createPermission('deleteAlbum');
        $deleteAlbum->description = 'Delete album';
        $auth->add($deleteAlbum);
        
    }

     public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => AuthItem::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AuthItem model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AuthItem();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
