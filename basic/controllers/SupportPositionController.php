<?php

namespace app\controllers;

use Yii;
use app\models\SupportPosition;
use app\models\SupportPositionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\User;
use app\components\AccessRules;
use yii\filters\AccessControl;


/**
 * SupportPositionController implements the CRUD actions for SupportPosition model.
 */
class SupportPositionController extends Controller
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
                               User::ROLE_ADMINISTRATOR, 
                           ],
                       ],
                    ],
                ],
        ];
    }

    /**
     * Lists all SupportPosition models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SupportPositionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SupportPosition model.
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
     * Creates a new SupportPosition model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SupportPosition();

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                Yii::$app->getSession()->setFlash('success', [
                     'type' => 'success',
                     'duration' => 3000,
                     'message' => 'Create Success',
                     'title' => 'Notification',
                     'positonY' => 'top',
                     'positonX' => 'right'
                ]);    
                    
                return $this->redirect(['index']);
            } else {
                Yii::$app->getSession()->setFlash('danger', [
                     'type' => 'danger',
                     'duration' => 3000,
                     'message' => 'Create Failed',
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
     * Updates an existing SupportPosition model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

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
     * Deletes an existing SupportPosition model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);;
        if($model->delete()){
            $size = Yii::$app->getDb()->createCommand('SELECT COUNT(*) AS total FROM support_position')->queryAll();
            $next_id = ((int) $size[0]['total']) + 1;
            Yii::$app->getDb()->createCommand('ALTER TABLE support_position ALGORITHM=COPY, AUTO_INCREMENT = :id', [':id' => $next_id])->execute();

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
        }
    } 


    /**
     * Finds the SupportPosition model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SupportPosition the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SupportPosition::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
