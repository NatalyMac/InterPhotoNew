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

    public $authModel = '\app\models\Users';

    public function actionAssignment()
    {
        $auth = Yii::$app->authManager;
        $model = new $this->authModel;
        $roles = $auth->getRoles();

        foreach ($roles as $role) {
            if ($model->role === $role) {
                $current_role = $auth->createRole($role);
                $auth->assign($current_role, $model->id);
            }
        }

    }

    public function actionCreate_permission_albumclients()

    {
        $auth = Yii::$app->authManager;

        $photographer = $auth->createRole('photographer');
        $admin = $auth->createRole('admin');
        
        $indexAlbumClients = $auth->createPermission('indexAlbumClients');
        $indexAlbumClients->description = 'Index AlbumClients';
        $auth->add($indexAlbumClients);

        $viewAlbumClients = $auth->createPermission('viewAlbumClients');
        $viewAlbumClients->description = 'View AlbumClients';
        $auth->add($viewAlbumClients);

        $createAlbumClients = $auth->createPermission('createAlbumClients');
        $createAlbumClients->description = 'Create AlbumClients';
        $auth->add($createAlbumClients);

        $deleteAlbumClients = $auth->createPermission('deleteAlbumClients');
        $deleteAlbumClients->description = 'Delete AlbumClients';
        $auth->add($deleteAlbumClients);

        $updateAlbumClients = $auth->createPermission('updateAlbumClients');
        $updateAlbumClients->description = 'Update AlbumClients';
        $auth->add($updateAlbumClients);

        $auth->addChild($admin, $indexAlbumClients);
        $auth->addChild($admin, $createAlbumClients);
        $auth->addChild($admin, $viewAlbumClients);
        $auth->addChild($admin, $updateAlbumClients);
        $auth->addChild($admin, $deleteAlbumClients);

        $rule = new \app\controllers\auth\AllowRule;
        $auth->add($rule);

        $indexAllowAlbumClients = $auth->createPermission('indexAllowAlbumClients');
        $indexAllowAlbumClients->description = 'Index allow AlbumClients';
        $auth->add($indexAllowAlbumClients);
        $auth->addChild($indexAllowAlbumClients, $indexAlbumClients);

        $viewAllowAlbumClients = $auth->createPermission('viewAllowAlbumClients');
        $viewAllowAlbumClients->description = 'View allow albumClients';
        $auth->add($viewAllowAlbumClients);
        $auth->addChild($viewAllowAlbumClients, $viewAlbumClients);

        $updateAllowAlbumClients = $auth->createPermission('updateAllowAlbumClients');
        $updateAllowAlbumClients->description = 'update allow albumClients';
        $auth->add($updateAllowAlbumClients);
        $auth->addChild($updateAllowAlbumClients, $updateAlbumClients);

        $deleteAllowAlbumClients = $auth->createPermission('deleteAllowAlbumClients');
        $deleteAllowAlbumClients->description = 'delete allow albumClients';
        $auth->add($deleteAllowAlbumClients);
        $auth->addChild($deleteAllowAlbumClients, $deleteAlbumClients);

        $auth->addChild($photographer, $createAlbumClients);
        $auth->addChild($photographer, $indexAllowAlbumClients);
        $auth->addChild($photographer, $viewAllowAlbumClients);
        $auth->addChild($photographer, $updateAllowAlbumClients);
        $auth->addChild($photographer, $deleteAllowAlbumClients);
    }

    public function actionCreate_permission_images()

    {
        $auth = Yii::$app->authManager;

        $photographer = $auth->createRole('photographer');
        $admin = $auth->createRole('admin');
        $client = $auth->createRole('client');

        $indexImages = $auth->createPermission('indexImages');
        $indexImages->description = 'Index images';
        $auth->add($indexImages);

        $viewImages = $auth->createPermission('viewImages');
        $viewImages->description = 'View images';
        $auth->add($viewImages);

        $createImages = $auth->createPermission('createImages');
        $createImages->description = 'Create images';
        $auth->add($createImages);

        $deleteImages = $auth->createPermission('deleteImages');
        $deleteImages->description = 'Delete images';
        $auth->add($deleteImages);

        $updateImages = $auth->createPermission('updateImages');
        $updateImages->description = 'Update images';
        $auth->add($updateImages);

        $auth->addChild($admin, $indexImages);
        $auth->addChild($admin, $createImages);
        $auth->addChild($admin, $viewImages);
        $auth->addChild($admin, $updateImages);
        $auth->addChild($admin, $deleteImages);

        $rule = new \app\controllers\auth\AuthorRule;
        $auth->add($rule);

        $updateOwnImages = $auth->createPermission('updateOwnImages');
        $updateOwnImages->description = 'Update own images';
        $updateOwnImages->ruleName = $rule->name;
        $auth->add($updateOwnImages);
        $auth->addChild($updateOwnImages, $updateImages);

        $viewOwnImages = $auth->createPermission('viewOwnImages');
        $viewOwnImages->description = 'View own album';
        $viewOwnImages->ruleName = $rule->name;
        $auth->add($viewOwnImages);
        $auth->addChild($viewOwnImages, $viewImages);

        $createOwnImages = $auth->createPermission('viewOwnImages');
        $createOwnImages->description = 'View own album';
        $createOwnImages->ruleName = $rule->name;
        $auth->add($createOwnImages);
        $auth->addChild($createOwnImages, $createImages);

        $deleteOwnImages = $auth->createPermission('viewOwnImages');
        $deleteOwnImages->description = 'View own album';
        $deleteOwnImages->ruleName = $rule->name;
        $auth->add($deleteOwnImages);
        $auth->addChild($deleteOwnImages, $deleteImages);

        $indexOwnImages = $auth->createPermission('viewOwnImages');
        $indexOwnImages->description = 'View own album';
        $indexOwnImages->ruleName = $rule->name;
        $auth->add($indexOwnImages);
        $auth->addChild($indexOwnImages, $indexImages);


        $auth->addChild($photographer, $indexOwnImages);
        $auth->addChild($photographer, $createOwnImages);
        $auth->addChild($photographer, $viewOwnImages);
        $auth->addChild($photographer, $updateOwnImages);
        $auth->addChild($photographer, $deleteOwnImages);

        $rule = new \app\controllers\auth\AllowRule;
        $auth->add($rule);

        $indexAllowImages = $auth->createPermission('indexAllowImages');
        $indexAllowImages->description = 'Index allow images';
        $auth->add($indexAllowImages);
        $auth->addChild($indexAllowImages, $indexImages);

        $viewAllowImages = $auth->createPermission('viewAllowAlbum');
        $viewAllowImages->description = 'View allow images';
        $auth->add($viewAllowImages);
        $auth->addChild($viewAllowImages, $viewImages);

        $auth->addChild($client, $indexAllowImages);
        $auth->addChild($client, $viewAllowImages);

    }

    public function actionCreate_permission_albums()
    {
        $auth = Yii::$app->authManager;

        $photographer = $auth->createRole('photographer');
        $admin = $auth->createRole('admin');
        $client = $auth->createRole('client');

        $indexAlbums = $auth->createPermission('indexAlbum');
        $indexAlbums->description = 'Index an album';
        $auth->add($indexAlbums);

        $viewAlbums = $auth->createPermission('viewAlbum');
        $viewAlbums->description = 'View album';
        $auth->add($viewAlbums);

        $createAlbums = $auth->createPermission('createAlbum');
        $createAlbums->description = 'Create an album';
        $auth->add($createAlbums);

        $updateAlbums = $auth->createPermission('updateAlbum');
        $updateAlbums->description = 'Update album';
        $auth->add($updateAlbums);

        $deleteAlbums = $auth->createPermission('deleteAlbum');
        $deleteAlbums->description = 'Delete album';
        $auth->add($deleteAlbums);

        $auth->addChild($admin, $indexAlbums);
        $auth->addChild($admin, $createAlbums);
        $auth->addChild($admin, $viewAlbums);
        $auth->addChild($admin, $updateAlbums);
        $auth->addChild($admin, $deleteAlbums);

        $rule = new \app\controllers\auth\AuthorRule;
        $auth->add($rule);

        $updateOwnAlbums = $auth->createPermission('updateOwnAlbum');
        $updateOwnAlbums->description = 'Update own album';
        $updateOwnAlbums->ruleName = $rule->name;
        $auth->add($updateOwnAlbums);
        $auth->addChild($updateOwnAlbums, $updateAlbums);

        $viewOwnAlbums = $auth->createPermission('viewOwnAlbum');
        $viewOwnAlbums->description = 'View own album';
        $viewOwnAlbums->ruleName = $rule->name;
        $auth->add($viewOwnAlbums);
        $auth->addChild($viewOwnAlbums, $viewAlbums);

        $indexOwnAlbums = $auth->createPermission('viewOwnAlbum');
        $indexOwnAlbums->description = 'View own album';
        $indexOwnAlbums->ruleName = $rule->name;
        $auth->add($indexOwnAlbums);
        $auth->addChild($indexOwnAlbums, $indexAlbums);

        $auth->addChild($photographer, $indexOwnAlbums);
        $auth->addChild($photographer, $createAlbums);
        $auth->addChild($photographer, $viewOwnAlbums);
        $auth->addChild($photographer, $updateOwnAlbums);

        $rule = new \app\controllers\auth\AllowRule;
        $auth->add($rule);

        $viewAllowAlbums = $auth->createPermission('viewAllowAlbum');
        $viewAllowAlbums->description = 'View allowed album';
        $viewAllowAlbums->ruleName = $rule->name;
        $auth->add($viewAllowAlbums);
        $auth->addChild($viewAllowAlbums, $viewAlbums);

        $indexAllowAlbums = $auth->createPermission('indexAllowAlbum');
        $indexAllowAlbums->description = 'Index allowed album';
        $indexAllowAlbums->ruleName = $rule->name;
        $auth->add($indexAllowAlbums);
        $auth->addChild($indexAllowAlbums, $indexAlbums);

        $auth->addChild($client, $indexAllowAlbums);
        $auth->addChild($client, $viewAllowAlbums);
    }

    public function actionCreate_permission_users()
    {
        $auth = Yii::$app->authManager;

        $photographer = $auth->createRole('photographer');
        $admin = $auth->createRole('admin');
        $client = $auth->createRole('client');

        $indexUsers = $auth->createPermission('indexUsers');
        $indexUsers->description = 'Index an user';
        $auth->add($indexUsers);

        $viewUsers = $auth->createPermission('viewUsers');
        $viewUsers->description = 'View user';
        $auth->add($viewUsers);

        $createUsers = $auth->createPermission('createUsers');
        $createUsers->description = 'Create an user';
        $auth->add($createUsers);

        $updateUsers = $auth->createPermission('updateUsers');
        $updateUsers->description = 'Update user';
        $auth->add($updateUsers);

        $deleteUsers = $auth->createPermission('deleteUser');
        $deleteUsers->description = 'Delete user';
        $auth->add($deleteUsers);

        $auth->addChild($admin, $indexUsers);
        $auth->addChild($admin, $viewUsers);
        $auth->addChild($admin, $updateUsers);
        $auth->addChild($admin, $createUsers);
        $auth->addChild($admin, $deleteUsers);

        $rule = new \app\controllers\auth\OwnerRule;
        $auth->add($rule);

        $viewOwnUsers = $auth->createPermission('viewOwnUser');
        $viewOwnUsers->description = 'View own user';
        $viewOwnUsers->ruleName = $rule->name;
        $auth->add($viewOwnUsers);
        $auth->addChild($viewOwnUsers, $viewUsers);

        $indexOwnUsers = $auth->createPermission('indexOwnUsers');
        $indexOwnUsers->description = 'Index own user';
        $indexOwnUsers->ruleName = $rule->name;
        $auth->add($indexOwnUsers);
        $auth->addChild($indexOwnUsers, $indexUsers);

        $updateOwnUsers = $auth->createPermission('updateOwnUsers');
        $updateOwnUsers->description = 'Update own user';
        $updateOwnUsers->ruleName = $rule->name;
        $auth->add($updateOwnUsers);
        $auth->addChild($updateOwnUsers, $updateUsers);

        $auth->addChild($photographer, $indexOwnUsers);
        $auth->addChild($photographer, $viewOwnUsers);
        $auth->addChild($photographer, $updateOwnUsers);

        $auth->addChild($client, $indexOwnUsers);
        $auth->addChild($client, $viewOwnUsers);
        $auth->addChild($client, $updateOwnUsers);


    }

    /**
     *
     */
    public function actionCreate_roles()
    {
        $auth = Yii::$app->authManager;
        $photographer = $auth->createRole('photographer');
        $admin = $auth->createRole('admin');
        $client = $auth->createRole('client');
        $auth->add($photographer);
        $auth->add($admin);
        $auth->add($client);
    }


    /**
     * @return string
     */
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
