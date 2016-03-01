<?php

namespace app\controllers;

use Yii;
use app\models\Report;
use app\models\ReportSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

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

        // $post = Yii::$app->request->post();
        if(!empty($_POST)){
            $erp->attributes=$_POST['Report'][1];
            $erp->service_family_id = 1;
            $erp->support_id = User::getSupportId(Yii::$app->user->getId());  
            $erp->created_at = date("Y-m-d H:i:s"); 
            $file_erp = UploadedFile::getInstance($erp, '[1]file');
            if(!empty($file_erp)){
                $erp->file = $file_erp;
                $erp->file->saveAs('uploads/reports/' . $erp->file->baseName . '.' . $erp->file->extension);    
                $erp->file_path = 'uploads/reports/' . $erp->file->baseName . '.' . $erp->file->extension;
            }
            
            $email->attributes=$_POST['Report'][2];
            $email->service_family_id = 2;
            $email->support_id = User::getSupportId(Yii::$app->user->getId());
            $email->created_at = date("Y-m-d H:i:s");  
            $file_email = UploadedFile::getInstance($email, '[2]file');
            if(!empty($file_email)){
                $email->file = $file_email;
                $email->file->saveAs('uploads/reports/' . $email->file->baseName . '.' . $email->file->extension);
                $email->file_path = 'uploads/reports/' . $email->file->baseName . '.' . $email->file->extension;
            }    

            $ap2t->attributes=$_POST['Report'][3];
            $ap2t->service_family_id = 3;
            $ap2t->support_id = User::getSupportId(Yii::$app->user->getId()); 
            $ap2t->created_at = date("Y-m-d H:i:s"); 
            $file_ap2t = UploadedFile::getInstance($ap2t, '[3]file');
            if(!empty($file_ap2t)){
                $ap2t->file = $file_ap2t;
                $ap2t->file->saveAs('uploads/reports/' . $ap2t->file->baseName . '.' . $ap2t->file->extension);
                $ap2t->file_path = 'uploads/reports/' . $ap2t->file->baseName . '.' . $ap2t->file->extension;
            }    

            $p2apst->attributes=$_POST['Report'][4];
            $p2apst->service_family_id = 4;
            $p2apst->support_id = User::getSupportId(Yii::$app->user->getId());  
            $p2apst->created_at = date("Y-m-d H:i:s"); 
            $file_p2apst = UploadedFile::getInstance($p2apst, '[4]file');
            if(!empty($file_p2apst)){
                $p2apst->file = $file_p2apst;
                $p2apst->file->saveAs('uploads/reports/' . $p2apst->file->baseName . '.' . $p2apst->file->extension);
                $p2apst->file_path = 'uploads/reports/' . $p2apst->file->baseName . '.' . $p2apst->file->extension;
            }    

            $bbo->attributes=$_POST['Report'][5];
            $bbo->service_family_id = 5;
            $bbo->support_id = User::getSupportId(Yii::$app->user->getId());  
            $bbo->created_at = date("Y-m-d H:i:s"); 
            $file_bbo = UploadedFile::getInstance($bbo, '[5]file');
            if(!empty($file_bbo)){
                $bbo->file = $file_bbo;
                $bbo->file->saveAs('uploads/reports/' . $bbo->file->baseName . '.' . $bbo->file->extension);
                $bbo->file_path = 'uploads/reports/' . $bbo->file->baseName . '.' . $bbo->file->extension;
            }    

            $apkt->attributes=$_POST['Report'][6];
            $apkt->service_family_id = 6;
            $apkt->support_id = User::getSupportId(Yii::$app->user->getId());  
            $apkt->created_at = date("Y-m-d H:i:s");
            $file_apkt = UploadedFile::getInstance($apkt, '[6]file');
            if(!empty($file_apkt)){
                $apkt->file = $file_apkt;
                $apkt->file->saveAs('uploads/reports/' . $apkt->file->baseName . '.' . $apkt->file->extension);
                $apkt->file_path = 'uploads/reports/' . $apkt->file->baseName . '.' . $apkt->file->extension;
            }    

            $itsm->attributes=$_POST['Report'][7];
            $itsm->service_family_id = 7;
            $itsm->support_id = User::getSupportId(Yii::$app->user->getId());  
            $itsm->created_at = date("Y-m-d H:i:s"); 
            $file_itsm = UploadedFile::getInstance($itsm, '[7]file');
            if(!empty($file_itsm)){
                $itsm->file = $file_itsm;
                $itsm->file->saveAs('uploads/reports/' . $itsm->file->baseName . '.' . $itsm->file->extension);
                $itsm->file_path = 'uploads/reports/' . $itsm->file->baseName . '.' . $itsm->file->extension;
            }    

             // Validate all models
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

                Yii::$app->getSession()->setFlash('success', [
                   'type' => 'success',
                   'duration' => 3000,
                   'icon' => 'fa fa-book',
                   'message' => 'Report Success',
                   'title' => 'Notification',
                   'positonY' => 'top',
                   'positonX' => 'right'
                ]);

                $this->redirect(['index']);
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
        $model = $this->findModel($id);
        if($model->file_path != NULL && file_exists($model->file_path)){
            unlink(getcwd() . '/' . $model->file_path); 
        }
        $model->delete();
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

    public function actionDownload($file_path) {
        if (file_exists($file_path)) {
            Yii::$app->response->sendFile($file_path)->send();
             Yii::$app->getSession()->setFlash('success', [
                   'type' => 'success',
                   'duration' => 3000,
                   'icon' => 'fa fa-download',
                   'message' => 'Download Success',
                   'title' => 'Notification',
                   'positonY' => 'top',
                   'positonX' => 'right'
                ]);
        } else {

            Yii::$app->getSession()->setFlash('danger', [
                   'type' => 'danger',
                   'duration' => 3000,
                   'icon' => 'fa fa-download',
                   'message' => 'Download Failed',
                   'title' => 'Notification',
                   'positonY' => 'top',
                   'positonX' => 'right'
                ]);
       }

        return $this->redirect(['index']);
    } 

    public function actionReport()
    {
         $content = $this->renderPartial('_reportView');
 
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}', 
             // set mPDF properties on the fly
            'options' => ['title' => 'Krajee Report Title'],
             // call mPDF methods on the fly
            'methods' => [ 
                'SetHeader'=>['Krajee Report Header'], 
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);
     
        // return the pdf output as per the destination setting
        return $pdf->render(); 

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
