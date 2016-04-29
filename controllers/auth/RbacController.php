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
     * Lists all AuthItem models.
     * @return mixed
     */

    public $authModel   = '\app\models\Users';

    // создаем разрешения
   
public function actionCreate_users()
{
 $auth = Yii::$app->authManager;
       
        $indexUser = $auth->createPermission('indexUser');
        $indexUser->description = 'Index an user';
        $auth->add($indexUser);

        // добавляем разрешение "viewAlbum"
        $viewUser = $auth->createPermission('viewUser');
        $viewUser->description = 'View user';
        $auth->add($viewUser);
        
        // добавляем разрешение "createAlbum"
        $createUser = $auth->createPermission('createUser');
        $createUser->description = 'Create an user';
        $auth->add($createUser);

        // добавляем разрешение "updateAlbum"
        $updateUser = $auth->createPermission('updateUser');
        $updateUser->description = 'Update user';
        $auth->add($updateUser);

        // добавляем разрешение "deleteAlbum"
        $deleteUser = $auth->createPermission('deleteUser');
        $deleteUser->description = 'Delete user';
        $auth->add($deleteUser);

        $rule = new \app\controllers\auth\AuthorRule;
        //$auth->add($rule);

        // добавляем разрешение "updateOwnPost" и привязываем к нему правило.
        
        $viewOwnUser = $auth->createPermission('viewOwnUser');
        $viewOwnUser->description = 'View own user';
        $viewOwnUser->ruleName = $rule->name;
        $auth->add($viewOwnUser);
        
        $indexOwnUser = $auth->createPermission('indexOwnUser');
        $indexOwnUser->description = 'Index own user';
        $indexOwnUser->ruleName = $rule->name;
        $auth->add($indexOwnUser);

        $updateOwnUser = $auth->createPermission('updateOwnUser');
        $updateOwnUser->description = 'Update own user';
        $updateOwnUser->ruleName = $rule->name;
        $auth->add($updateOwnUser);
        
        $auth->addChild($updateOwnUser, $updateUser);
        $auth->addChild($indexOwnUser, $indexUser);
        $auth->addChild($viewOwnUser, $viewUser);


          $photographer = $auth->createPermission('photographer');
          $client = $auth->createPermission('client');
          $admin = $auth->createPermission('admin'); 


           $auth->addChild($photographer, $indexOwnUser);
           $auth->addChild($photographer, $viewOwnUser);
           $auth->addChild($photographer, $updateOwnUser);
           $auth->addChild($photographer, $createUser);
           
           $auth->addChild($client, $indexOwnUser);
           $auth->addChild($client, $viewOwnUser);
           $auth->addChild($client, $updateOwnUser);
           $auth->addChild($client, $createUser);
   
            $auth->addChild($admin, $indexUser);
            $auth->addChild($admin, $viewUser);
            $auth->addChild($admin, $updateUser);
             $auth->addChild($admin, $createUser);
              $auth->addChild($admin, $deleteUser);


    
}



public function actionCreate_images()
{
    $auth = Yii::$app->authManager;
    $indexImages = $auth->createPermission('indexImages');
    $indexImages->description = 'Index images';
    $auth->add($indexImages);
    
    $indexAllowImages = $auth->createPermission('indexAllowImages');
    $indexAllowImages->description = 'Index allow images';
    $auth->add($indexAllowImages);

    $indexAlbum = $auth->createPermission('indexAlbum');
    $indexAllowAlbum = $auth->createPermission('indexAllowAlbum');
    $auth->addChild($indexImages, $indexAlbum);
    $auth->addChild($indexAllowImages, $indexImages);

    $photographer = $auth->createPermission('photographer');
    $client = $auth->createPermission('client');
    $admin = $auth->createPermission('admin');    

    $auth->addChild($photographer, $indexAllowImages);
    $auth->addChild($admin, $indexImages);
    $auth->addChild($client, $indexAllowImages);

}

   public function actionCreate_rule_index()
    {
        $auth = Yii::$app->authManager;

        // add the rule
        $rule = new \app\controllers\auth\AllowRule;
        //$auth->add($rule);

        // добавляем разрешение "updateOwnPost" и привязываем к нему правило.
        $indexAllowAlbum = $auth->createPermission('indexAllowAlbum');
       // $indexOwnAlbum->description = 'Index own album';
        $indexAllowAlbum->ruleName = $rule->name;
        //$auth->add($indexOwnAlbum);

      //  $indexAlbum = $auth->createPermission('indexAlbum');
        // "updateOwnPost" будет использоваться из "updatePost"
       // $auth->addChild($indexAllowAlbum, $indexAlbum);
        // проверить в таблице item_child photograper -> udateAlbum
        // удалить, иначе нет правильного наследования или в ролях коммент
        $photographer = $auth->createPermission('photographer');
        // разрешаем "автору" обновлять его посты
        $auth->addChild($photographer, $indexAllowAlbum);

    }


    
public function actionClient()
{       
    $auth = Yii::$app->authManager;
    $rule = new \app\controllers\auth\AllowRule;
     $auth->add($rule);

        $indexAlbum = $auth->createPermission('indexAlbum');
        $viewAlbum = $auth->createPermission('viewAlbum');
     

        $client = $auth->createRole('client');
        $auth->add($client);

        $auth->addChild($client, $indexAlbum);
        $auth->addChild($client, $viewAlbum);
        
       


        // добавляем разрешение "updateOwnPost" и привязываем к нему правило.
        $viewAllowAlbum = $auth->createPermission('viewAllowAlbum');
        $viewAllowAlbum->description = 'View allowed album';
        $viewAllowAlbum->ruleName = $rule->name;
        $auth->add($viewAllowAlbum);
        
        $indexAllowAlbum = $auth->createPermission('indexAllowAlbum');
        $indexAllowAlbum->description = 'Index allowed album';
        $indexAllowAlbum->ruleName = $rule->name;
        $auth->add($indexAllowAlbum);
        
        $auth->addChild($viewAllowAlbum, $viewAlbum);
        $auth->addChild($indexAllowAlbum, $indexAlbum);
        $client = $auth->createPermission('client');
        // разрешаем "автору" обновлять его посты
        $auth->addChild($client, $viewAllowAlbum);
        $auth->addChild($client, $indexAllowAlbum);
}


    public function actionAssignment()
    {
       $auth = Yii::$app->authManager;
       $model = new $this->authModel;
       $roles=$auth->getRoles();

        foreach ($roles as $role) {
            if ($model->role === $role)
                { 
                    $current_role = $auth->createRole($role);
                    $auth->assign($current_role, $model->id);
                }
        }

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


    public function actionCreate_rule_update()
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
       

       return $this->render('index', ['dataProvider' => $dataProvider,]);
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
