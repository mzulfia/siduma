<?php

namespace app\controllers;

use Yii;
use app\models\ServiceFamily;
use app\models\ServiceFamilySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\User;
use app\components\AccessRules;
use yii\filters\AccessControl;


/**
 * ServiceFamilyController implements the CRUD actions for ServiceFamily model.
 */
class ServiceFamilyController extends Controller
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
               'ruleConfig' => [
                   'class' => AccessRules::className(),
               ],
               'only' => ['index','create', 'update', 'delete'],
               'rules' => [
                       [
                           'actions' => ['index','create', 'update', 'delete'],
                           'allow' => true,
                           'roles' => [
                               User::ROLE_ADMINISTRATOR
                           ],
                       ],
                       [
                           'actions' => ['index','create', 'update'],
                           'allow' => true,
                           'roles' => [
                               User::ROLE_SUPERVISOR
                           ],
                       ],
                    ],
                ],
        ];
    }

    /**
     * Lists all ServiceFamily models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ServiceFamilySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new ServiceFamily model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ServiceFamily();

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                Yii::$app->getSession()->setFlash('success', [
                     'type' => 'success',
                     'duration' => 3000,
                     'message' => 'Update Success',
                     'title' => 'Notification',
                     'positonY' => 'top',
                     'positonX' => 'right'
                ]);    
                    
                return $this->redirect(['index']);
            } else {
                Yii::$app->getSession()->setFlash('danger', [
                     'type' => 'danger',
                     'duration' => 3000,
                     'message' => 'Update Failed',
                     'title' => 'Notification',
                     'positonY' => 'top',
                     'positonX' => 'right'
                ]);    
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ServiceFamily model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if($model->update()){
                Yii::$app->getSession()->setFlash('success', [
                     'type' => 'success',
                     'duration' => 3000,
                     'message' => 'Update Success',
                     'title' => 'Notification',
                     'positonY' => 'top',
                     'positonX' => 'right'
                ]);    
                    
                return $this->redirect(['index']);
            } else {
                Yii::$app->getSession()->setFlash('danger', [
                     'type' => 'danger',
                     'duration' => 3000,
                     'message' => 'Update Failed',
                     'title' => 'Notification',
                     'positonY' => 'top',
                     'positonX' => 'right'
                ]);    
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ServiceFamily model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
       $model = $this->findModel($id);
        if($model->delete()){
          $size = Yii::$app->getDb()->createCommand('SELECT COUNT(*) AS total FROM service_family')->queryAll();
          $next_id = ((int) $size[0]['total']) + 1;
          Yii::$app->getDb()->createCommand('ALTER TABLE service_family AUTO_INCREMENT = :id', [':id' => $next_id])->execute();

          Yii::$app->getSession()->setFlash('success', [
               'type' => 'success',
               'duration' => 3000,
               'message' => 'Delete Success',
               'title' => 'Notification',
               'positonY' => 'top',
               'positonX' => 'right'
          ]);    

          return $this->redirect(['index']);
        } else {
            Yii::$app->getSession()->setFlash('danger', [
                 'type' => 'danger',
                 'duration' => 3000,
                 'message' => 'Delete Failed',
                 'title' => 'Notification',
                 'positonY' => 'top',
                 'positonX' => 'right'
            ]); 

            return $this->redirect(['index']);   
        }
    }

    /**
     * Finds the ServiceFamily model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ServiceFamily the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ServiceFamily::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
