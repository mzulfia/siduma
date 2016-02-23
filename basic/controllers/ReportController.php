<?php

namespace app\controllers;

use Yii;
use app\models\Report;
use app\models\ReportSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\User;

/**
 * ReportController implements the CRUD actions for Report model.
 */
class ReportController extends Controller
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
        ];
    }

    /**
     * Lists all Report models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Report model.
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
     * Creates a new Report model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $erp = new Report();
        $email = new Report();
        $ap2t = new Report();
        $p2apst = new Report();
        $bbo = new Report();
        $apkt = new Report();
        $itsm = new Report();
        date_default_timezone_set("Asia/Jakarta");

        $post = Yii::$app->request->post();
        if(!empty($_POST)){
            $erp->attributes=$_POST['Report'][1];
            $erp->service_family_id = 1;
            $erp->support_id = User::getSupportId(Yii::$app->user->getId());  
            $erp->created_at = date("Y-m-d H:i:s"); 
            $email->attributes=$_POST['Report'][2];
            $email->service_family_id = 2;
            $email->support_id = User::getSupportId(Yii::$app->user->getId());
            $email->created_at = date("Y-m-d H:i:s");   
            $ap2t->attributes=$_POST['Report'][3];
            $ap2t->service_family_id = 3;
            $ap2t->support_id = User::getSupportId(Yii::$app->user->getId()); 
            $ap2t->created_at = date("Y-m-d H:i:s"); 
            $p2apst->attributes=$_POST['Report'][4];
            $p2apst->service_family_id = 4;
            $p2apst->support_id = User::getSupportId(Yii::$app->user->getId());  
            $p2apst->created_at = date("Y-m-d H:i:s"); 
            $bbo->attributes=$_POST['Report'][5];
            $bbo->service_family_id = 5;
            $bbo->support_id = User::getSupportId(Yii::$app->user->getId());  
            $bbo->created_at = date("Y-m-d H:i:s"); 
            $apkt->attributes=$_POST['Report'][6];
            $apkt->service_family_id = 6;
            $apkt->support_id = User::getSupportId(Yii::$app->user->getId());  
            $apkt->created_at = date("Y-m-d H:i:s"); 
            $itsm->attributes=$_POST['Report'][7];
            $itsm->service_family_id = 7;
            $itsm->support_id = User::getSupportId(Yii::$app->user->getId());  
            $itsm->created_at = date("Y-m-d H:i:s"); 

             // Validate all three model
            $valid=$erp->validate();
            $valid=$email->validate() && $valid;
            $valid=$ap2t->validate() && $valid;
            $valid=$p2apst->validate() && $valid;
            $valid=$bbo->validate() && $valid;
            $valid=$apkt->validate() && $valid;
            $valid=$itsm->validate() && $valid;

            if($valid)
            { 
                $erp->save();
                $email->save();
                $ap2t->save();
                $p2apst->save();
                $bbo->save();
                $apkt->save();
                $itsm->save();

                $this->redirect(array('index'));
            }

        }

        return $this->render('create',[
            'erp'=>$erp,
            'email'=>$email,
            'ap2t'=>$ap2t,
            'p2apst'=>$p2apst,
            'bbo'=>$bbo,
            'apkt'=>$apkt,
            'itsm'=>$itsm,
        ]);


        // $post = Yii::$app->request->post();

        // if($model->load($post)){
        //     $erp->service_family_id = 
        //     date_default_timezone_set("Asia/Jakarta");
        //     $model->created_at = date("Y-m-d H:i:s"); 
        //     $model->support_id = User::getSupportId(Yii::$app->user->getId());            
        //     if($model->save()){
        //         return $this->redirect(['view', 'id' => $model->report_id]);
        //     }
        // } else {
        //     return $this->render('create', [
        //         'model' => $model,
        //     ]);
        // }
    }

    /**
     * Updates an existing Report model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->report_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Report model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionIndexunauthorized()
    {
        $searchModel = new ReportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('indexUnauthorized', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Finds the Report model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Report the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Report::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
