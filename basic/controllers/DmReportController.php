<?php

namespace app\controllers;

use Yii;
use app\models\DmReport;
use app\models\DmReportSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use app\models\User;
use app\models\Shift;
use app\models\Schedule;

/**
 * DmReportController implements the CRUD actions for DmReport model.
 */
class DmReportController extends Controller
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
     * Lists all DmReport models.
     * @return mixed
     */
    public function actionIndex(){
        // if(User::getRoleId(Yii::$app->user->getId()) == User::ROLE_ADMINISTRATOR || Schedule::getIsDM(date('Y-m-d'), Shift::getShift(date("H:i:s"))->shift_id, User::getSupportId(Yii::$app->user->getId()))){
        if(User::getRoleId(Yii::$app->user->getId()) == User::ROLE_ADMINISTRATOR){
            $searchModel = new DmReportSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else{
            $support_id = User::getSupportId(Yii::$app->user->getId());
            $searchModel = new DmReportSearch();
            $searchModel->support_id =  $support_id;
            $dataProvider = $searchModel->searchDmReports(Yii::$app->request->queryParams);

            return $this->render('indexUnauthorized', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);

        }
    }

    /**
     * Displays a single DmReport model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('viewUnauthorized', [
                'model' => $this->findModel($id),
            ]);
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new DmReport model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {       
        $erp = new DmReport();
        $email = new DmReport();
        $ap2t = new DmReport();
        $p2apst = new DmReport();
        $bbo = new DmReport();
        $apkt = new DmReport();
        $itsm = new DmReport();
        date_default_timezone_set("Asia/Jakarta");

        if(!empty($_POST)){
            $erp->attributes=$_POST['DmReport'][1];
            $erp->service_family_id = 1;
            $erp->support_id = User::getSupportId(Yii::$app->user->getId());  
            $erp->created_at = date("Y-m-d H:i:s"); 
            $file_erp = UploadedFile::getInstance($erp, '[1]file');
            if(!empty($file_erp)){
                $erp->file = $file_erp;
                $erp->file->saveAs('uploads/reports/dutymanager/' . $erp->file->baseName . '.' . $erp->file->extension);    
                $erp->file_path = 'uploads/reports/dutymanager/' . $erp->file->baseName . '.' . $erp->file->extension;
            }
            
            $email->attributes=$_POST['DmReport'][2];
            $email->service_family_id = 2;
            $email->support_id = User::getSupportId(Yii::$app->user->getId());
            $email->created_at = date("Y-m-d H:i:s");  
            $file_email = UploadedFile::getInstance($email, '[2]file');
            if(!empty($file_email)){
                $email->file = $file_email;
                $email->file->saveAs('uploads/reports/dutymanager/' . $email->file->baseName . '.' . $email->file->extension);
                $email->file_path = 'uploads/reports/dutymanager/' . $email->file->baseName . '.' . $email->file->extension;
            }    

            $ap2t->attributes=$_POST['DmReport'][3];
            $ap2t->service_family_id = 3;
            $ap2t->support_id = User::getSupportId(Yii::$app->user->getId()); 
            $ap2t->created_at = date("Y-m-d H:i:s"); 
            $file_ap2t = UploadedFile::getInstance($ap2t, '[3]file');
            if(!empty($file_ap2t)){
                $ap2t->file = $file_ap2t;
                $ap2t->file->saveAs('uploads/reports/dutymanager/' . $ap2t->file->baseName . '.' . $ap2t->file->extension);
                $ap2t->file_path = 'uploads/reports/dutymanager/' . $ap2t->file->baseName . '.' . $ap2t->file->extension;
            }    

            $p2apst->attributes=$_POST['DmReport'][4];
            $p2apst->service_family_id = 4;
            $p2apst->support_id = User::getSupportId(Yii::$app->user->getId());  
            $p2apst->created_at = date("Y-m-d H:i:s"); 
            $file_p2apst = UploadedFile::getInstance($p2apst, '[4]file');
            if(!empty($file_p2apst)){
                $p2apst->file = $file_p2apst;
                $p2apst->file->saveAs('uploads/reports/dutymanager/' . $p2apst->file->baseName . '.' . $p2apst->file->extension);
                $p2apst->file_path = 'uploads/reports/dutymanager/' . $p2apst->file->baseName . '.' . $p2apst->file->extension;
            }    

            $bbo->attributes=$_POST['DmReport'][5];
            $bbo->service_family_id = 5;
            $bbo->support_id = User::getSupportId(Yii::$app->user->getId());  
            $bbo->created_at = date("Y-m-d H:i:s"); 
            $file_bbo = UploadedFile::getInstance($bbo, '[5]file');
            if(!empty($file_bbo)){
                $bbo->file = $file_bbo;
                $bbo->file->saveAs('uploads/reports/dutymanager/' . $bbo->file->baseName . '.' . $bbo->file->extension);
                $bbo->file_path = 'uploads/reports/dutymanager/' . $bbo->file->baseName . '.' . $bbo->file->extension;
            }    

            $apkt->attributes=$_POST['DmReport'][6];
            $apkt->service_family_id = 6;
            $apkt->support_id = User::getSupportId(Yii::$app->user->getId());  
            $apkt->created_at = date("Y-m-d H:i:s");
            $file_apkt = UploadedFile::getInstance($apkt, '[6]file');
            if(!empty($file_apkt)){
                $apkt->file = $file_apkt;
                $apkt->file->saveAs('uploads/reports/dutymanager/' . $apkt->file->baseName . '.' . $apkt->file->extension);
                $apkt->file_path = 'uploads/reports/dutymanager/' . $apkt->file->baseName . '.' . $apkt->file->extension;
            }    

            $itsm->attributes=$_POST['DmReport'][7];
            $itsm->service_family_id = 7;
            $itsm->support_id = User::getSupportId(Yii::$app->user->getId());  
            $itsm->created_at = date("Y-m-d H:i:s"); 
            $file_itsm = UploadedFile::getInstance($itsm, '[7]file');
            if(!empty($file_itsm)){
                $itsm->file = $file_itsm;
                $itsm->file->saveAs('uploads/reports/dutymanager/' . $itsm->file->baseName . '.' . $itsm->file->extension);
                $itsm->file_path = 'uploads/reports/dutymanager/' . $itsm->file->baseName . '.' . $itsm->file->extension;
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

    }

    /**
     * Updates an existing DmReport model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
       $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) 
        {
            $model->file = UploadedFile::getInstance($model, 'file');
            if(!is_null($model->file))
            {
                $ext =  end((explode(".", $model->file->name)));
                $filename = $model->file->baseName;
                if(!empty($model->file_path)){
                    $dm = DmReport::findOne($id);
                    $dm->deleteFile();
                    $model->file_path =  'uploads/reports/dutymanager/' . $filename.".{$ext}";
                    if($model->update()){
                        $model->file->saveAs('uploads/reports/dutymanager/' . $filename .".{$ext}");   
                        Yii::$app->getSession()->setFlash('success', [
                           'type' => 'success',
                           'duration' => 3000,
                           'icon' => 'fa fa-upload',
                           'message' => 'Upload Success',
                           'title' => 'Notification',
                           'positonY' => 'top',
                           'positonX' => 'right'
                        ]);

                        return $this->redirect(['index']);

                    } else {
                        Yii::$app->getSession()->setFlash('danger', [
                           'type' => 'danger',
                           'duration' => 3000,
                           'icon' => 'fa fa-upload',
                           'message' => 'Upload Failed',
                           'title' => 'Notification',
                           'positonY' => 'top',
                           'positonX' => 'right'
                        ]);

                        return $this->render('update', [
                            'model' => $model,
                        ]);
                    }
                }
                else
                {
                    $model->file_path =  'uploads/reports/dutymanager/' . $filename.".{$ext}";
                    if($model->update()){
                        Yii::$app->getSession()->setFlash('success', [
                           'type' => 'success',
                           'duration' => 3000,
                           'icon' => 'fa fa-upload',
                           'message' => 'Upload Success',
                           'title' => 'Notification',
                           'positonY' => 'top',
                           'positonX' => 'right'
                        ]);

                        $model->file->saveAs('uploads/reports/dutymanager/' . $filename .".{$ext}");   
                        return $this->redirect(['index']);

                    } else{
                        Yii::$app->getSession()->setFlash('danger', [
                           'type' => 'danger',
                           'duration' => 3000,
                           'icon' => 'fa fa-upload',
                           'message' => 'Upload Failed',
                           'title' => 'Notification',
                           'positonY' => 'top',
                           'positonX' => 'right'
                        ]);

                        return $this->redirect(['index']);
                    }   
                }
            } 
            else
            {
                if($model->update()){
                    Yii::$app->getSession()->setFlash('success', [
                       'type' => 'success',
                       'duration' => 3000,
                       'icon' => 'fa fa-upload',
                       'message' => 'Update Success',
                       'title' => 'Notification',
                       'positonY' => 'top',
                       'positonX' => 'right'
                    ]);

                    return $this->redirect(['index']);

                } else{
                    Yii::$app->getSession()->setFlash('danger', [
                       'type' => 'danger',
                       'duration' => 3000,
                       'icon' => 'fa fa-upload',
                       'message' => 'Update Success',
                       'title' => 'Notification',
                       'positonY' => 'top',
                       'positonX' => 'right'
                    ]);

                    return $this->redirect(['index']);
                }   
            }
        } 
        else 
        {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDownload($file_path) {
        if (file_exists($file_path)) {
            Yii::$app->response->sendFile($file_path)->send();
             
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

    public function actionReporthistory() {
        $model = new Schedule();
        $service_name = '';
        $normal_erp = 0.0;
        $warning_erp = 0.0;
        $critical_erp = 0.0;
        $normal_email = 0.0;
        $warning_email = 0.0;
        $critical_email = 0.0;
        $normal_ap2t = 0.0;
        $warning_ap2t = 0.0;
        $critical_ap2t = 0.0;
        $normal_p2apst = 0.0;
        $warning_p2apst = 0.0;
        $critical_p2apst = 0.0;
        $normal_bbo = 0.0;
        $warning_bbo = 0.0;
        $critical_bbo = 0.0;
        $normal_apkt = 0.0;
        $warning_apkt = 0.0;
        $critical_apkt = 0.0;
        $normal_itsm = 0.0;
        $warning_itsm = 0.0;
        $critical_itsm = 0.0;
 

        $date = '';
        if(isset($_POST['dashboard-button']) && $_POST['Schedule']['date'] != ''){
            $date = $_POST['Schedule']['date'];
            $normal_erp = (float) number_format((float)DmReport::getNormalCondition($date, 1), 2, '.', '');
            $warning_erp = (float) number_format((float)DmReport::getWarningCondition($date, 1), 2, '.', '');
            $critical_erp = (float) number_format((float)DmReport::getCriticalCondition($date, 1), 2, '.', '');
            $normal_email = (float) number_format((float)DmReport::getNormalCondition($date, 2), 2, '.', '');
            $warning_email = (float) number_format((float)DmReport::getWarningCondition($date, 2), 2, '.', '');
            $critical_email = (float) number_format((float)DmReport::getCriticalCondition($date, 2), 2, '.', '');
            $normal_ap2t = (float) number_format((float)DmReport::getNormalCondition($date, 3), 2, '.', '');
            $warning_ap2t = (float) number_format((float)DmReport::getWarningCondition($date, 3), 2, '.', '');
            $critical_ap2t = (float) number_format((float)DmReport::getCriticalCondition($date, 3), 2, '.', '');
            $normal_p2apst = (float) number_format((float)DmReport::getNormalCondition($date, 4), 2, '.', '');
            $warning_p2apst = (float) number_format((float)DmReport::getWarningCondition($date, 4), 2, '.', '');
            $critical_p2apst = (float) number_format((float)DmReport::getCriticalCondition($date, 4), 2, '.', '');
            $normal_bbo = (float) number_format((float)DmReport::getNormalCondition($date, 5), 2, '.', '');
            $warning_bbo = (float) number_format((float)DmReport::getWarningCondition($date, 5), 2, '.', '');
            $critical_bbo = (float) number_format((float)DmReport::getCriticalCondition($date, 5), 2, '.', '');
            $normal_apkt = (float) number_format((float)DmReport::getNormalCondition($date, 6), 2, '.', '');
            $warning_apkt = (float) number_format((float)DmReport::getWarningCondition($date, 6), 2, '.', '');
            $critical_apkt = (float) number_format((float)DmReport::getCriticalCondition($date, 6), 2, '.', '');
            $normal_itsm = (float) number_format((float)DmReport::getNormalCondition($date, 7), 2, '.', '');
            $warning_itsm = (float) number_format((float)DmReport::getWarningCondition($date, 7), 2, '.', '');
            $critical_itsm = (float) number_format((float)DmReport::getCriticalCondition($date, 7), 2, '.', '');
        }        

        return $this->render('reportHistory', [
            'model' => $model,
            'date' => $date,
            'normal_erp' => $normal_erp,
            'warning_erp' => $warning_erp,
            'critical_erp' => $critical_erp,
            'normal_email' => $normal_email,
            'warning_email' => $warning_email,
            'critical_email' => $critical_email,
            'normal_ap2t' => $normal_ap2t,
            'warning_ap2t' => $warning_ap2t,
            'critical_ap2t' => $critical_ap2t,
            'normal_p2apst' => $normal_p2apst,
            'warning_p2apst' => $warning_p2apst,
            'critical_p2apst' => $critical_p2apst,
            'normal_bbo' => $normal_bbo,
            'warning_bbo' => $warning_bbo,
            'critical_bbo' => $critical_bbo,
            'normal_apkt' => $normal_apkt,
            'warning_apkt' => $warning_apkt,
            'critical_apkt' => $critical_apkt,
            'normal_itsm' => $normal_itsm,
            'warning_itsm' => $warning_itsm,
            'critical_itsm' => $critical_itsm,
        ]);    
    } 


    /**
     * Deletes an existing DmReport model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->deleteFile();
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DmReport model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DmReport the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DmReport::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
