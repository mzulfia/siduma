<?php

namespace app\controllers;
 
use Yii;

use app\models\User;
use app\models\UserSearch;
use app\models\Support;
use app\models\Management;
use app\components\AccessRules;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;



/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller 
{
    public function behaviors()
    {
         return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
           'access' => [
               'class' => AccessControl::className(),
               // We will override the default rule config with the new AccessRule class
               'ruleConfig' => [
                   'class' => AccessRules::className(),
               ],
               'only' => ['index','create', 'update', 'delete'],
               'rules' => [
                       [
                           'actions' => ['index','create'],
                           'allow' => true,
                           // Allow users, moderators and admins to create
                           'roles' => [
                               User::ROLE_ADMINISTRATOR
                           ],
                       ],
                       [
                           'actions' => ['update'],
                           'allow' => true,
                           // Allow moderators and admins to update
                           'roles' => [
                               User::ROLE_ADMINISTRATOR
                           ],
                       ],
                       [
                           'actions' => ['delete'],
                           'allow' => true,
                           // Allow admins to delete
                           'roles' => [
                               User::ROLE_ADMINISTRATOR
                       ],
                    ],
                ],
            ],    
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $support = new Support();
        $management  = new Management();
        
        $post = Yii::$app->request->post();

        if($model->load($post)){
            $model->salt_password = Yii::$app->security->generatePasswordHash($model->password);
            if ($model->save()) {
                if($model->role_id == User::ROLE_SUPPORT)
                {
                    $support->user_id = $model->user_id;
                    if($support->save())
                    {   
                        Yii::$app->getSession()->setFlash('success', [
                         'type' => 'success',
                         'duration' => 5000,
                         'icon' => 'fa fa-users',
                         'message' => 'My Message',
                         'title' => 'My Title',
                         'positonY' => 'top',
                         'positonX' => 'left'
                        ]);

                        $this->redirect(array('index'));
                    }
                    else
                    {
                        // Yii::app()->user->setFlash('error', "Gagal dibuat!");
                    }
                } 
                else 
                {
                    $management->user_id = $model->user_id;
                    if($management->save())
                    {
                        Yii::$app->getSession()->setFlash('success', [
                         'type' => 'success',
                         'duration' => 5000,
                         'icon' => 'fa fa-users',
                         'message' => 'My Message',
                         'title' => 'My Title',
                         'positonY' => 'top',
                         'positonX' => 'left'
                        ]);
                        
                        $this->redirect(array('index'));
                    }
                    else
                    {
                        // Yii::app()->user->setFlash('error', "Gagal dibuat!");
                    }
                }    
            }   
        }
        
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->user_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
