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
use app\models\ServiceFamily;
use app\components\AccessRules;
use yii\filters\AccessControl;


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
            'access' => [
               'class' => AccessControl::className(),
               'ruleConfig' => [
                   'class' => AccessRules::className(),
               ],
               'only' => ['index','create', 'update', 'delete', 'view'],
               'rules' => [
                       [
                           'actions' => ['index', 'create', 'update', 'delete', 'view'],
                           'allow' => true,
                           'roles' => [
                               User::ROLE_ADMINISTRATOR, 
                           ],
                       ],
                       [
                           'actions' => ['index', 'create', 'update', 'view'],
                           'allow' => true,
                           'roles' => [
                               User::ROLE_SUPPORT,
                           ],
                       ],
                       [
                           'actions' => ['index', 'view'],
                           'allow' => true,
                           'roles' => [
                               User::ROLE_MANAGEMENT,
                               User::ROLE_SUPERVISOR,
                           ],
                       ],
                    ],
                ],
        ];
    }

    /**
     * Lists all DmReport models.
     * @return mixed
     */
    public function actionIndex(){
        if(User::getRoleId(Yii::$app->user->getId()) == User::ROLE_ADMINISTRATOR){
            $searchModel = new DmReportSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } elseif(User::getRoleId(Yii::$app->user->getId()) == User::ROLE_MANAGEMENT || User::getRoleId(Yii::$app->user->getId()) == User::ROLE_SUPERVISOR) {
            $searchModel = new DmReportSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('indexMgtSpv', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
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
        if(User::getRoleId(Yii::$app->user->getId()) == User::ROLE_ADMINISTRATOR)
        {
            date_default_timezone_set("Asia/Jakarta");
            $service_family = [];
            for($i=0; $i < sizeof(ServiceFamily::find()->all()); $i++){
                $service_family[$i] = new DmReport();
            }

            if(!empty($_POST)){
                for($i=0; $i < sizeof($service_family); $i++){
                    $service_family[$i]->attributes=$_POST['DmReport'][$i];
                    $service_family[$i]->service_family_id = $i+1;
                    $service_family[$i]->support_id = User::getSupportId(Yii::$app->user->getId());  
                    $service_family[$i]->created_at = date("Y-m-d H:i:s"); 
                    $file_attribute = '['.$i.']file';
                    $file = UploadedFile::getInstance($service_family[$i], $file_attribute);
                    if(!empty($file)){
                        $service_family[$i]->file = $file;
                        $service_family[$i]->file->saveAs('uploads/reports/dutymanager/' . $service_family[$i]->file->baseName . '.' . $service_family[$i]->file->extension);    
                        $service_family[$i]->file_path = 'uploads/reports/dutymanager/' . $service_family[$i]->file->baseName . '.' . $service_family[$i]->file->extension;
                    } 
                }   
                for($i=0; $i < sizeof($service_family); $i++){
                    if($i == 0){
                        $valid=$service_family[$i]->validate();    
                    } else {
                        $valid=$service_family[$i]->validate() && $valid;    
                    }
                }


                if($valid)
                { 
                    for($i=0; $i < sizeof($service_family); $i++){
                        $service_family[$i]->save();
                    }

                    Yii::$app->getSession()->setFlash('success', [
                       'type' => 'success',
                       'duration' => 3000,
                       'icon' => 'fa fa-upload',
                       'message' => 'Upload Success',
                       'title' => 'Notification',
                       'positonY' => 'top',
                       'positonX' => 'right'
                    ]);

                    $this->redirect(['index']);
                }
                else
                {
                    Yii::$app->getSession()->setFlash('danger', [
                       'type' => 'danger',
                       'duration' => 3000,
                       'icon' => 'fa fa-upload',
                       'message' => 'Upload Failed',
                       'title' => 'Notification',
                       'positonY' => 'top',
                       'positonX' => 'right'
                    ]);

                    return $this->render('create', [
                        'service_family' => $service_family,
                    ]);
                }
            }

            return $this->render('create', [
                    'service_family' => $service_family,
                ]);
        } else {
          date_default_timezone_set("Asia/Jakarta");
          if(Schedule::getIsDmNow(date('Y-m-d'), Shift::getShift(date("H:i:s"))->shift_id, User::getSupportId(Yii::$app->user->getId()))) {
              date_default_timezone_set("Asia/Jakarta");
              $service_family = [];
              for($i=0; $i < sizeof(ServiceFamily::find()->all()); $i++){
                  $service_family[$i] = new DmReport();
              }

              if(!empty($_POST)){
                  for($i=0; $i < sizeof($service_family); $i++){
                      $service_family[$i]->attributes=$_POST['DmReport'][$i];
                      $service_family[$i]->service_family_id = $i+1;
                      $service_family[$i]->support_id = User::getSupportId(Yii::$app->user->getId());  
                      $service_family[$i]->created_at = date("Y-m-d H:i:s"); 
                      $file_attribute = '['.$i.']file';
                      $file = UploadedFile::getInstance($service_family[$i], $file_attribute);
                      if(!empty($file)){
                          $service_family[$i]->file = $file;
                          $service_family[$i]->file->saveAs('uploads/reports/dutymanager/' . $service_family[$i]->file->baseName . '.' . $service_family[$i]->file->extension);    
                          $service_family[$i]->file_path = 'uploads/reports/dutymanager/' . $service_family[$i]->file->baseName . '.' . $service_family[$i]->file->extension;
                      } 
                  }   
                  for($i=0; $i < sizeof($service_family); $i++){
                      if($i == 0){
                          $valid=$service_family[$i]->validate();    
                      } else {
                          $valid=$service_family[$i]->validate() && $valid;    
                      }
                  }


                  if($valid)
                  { 
                      for($i=0; $i < sizeof($service_family); $i++){
                          $service_family[$i]->save();
                      }

                      Yii::$app->getSession()->setFlash('success', [
                         'type' => 'success',
                         'duration' => 3000,
                         'icon' => 'fa fa-upload',
                         'message' => 'Upload Success',
                         'title' => 'Notification',
                         'positonY' => 'top',
                         'positonX' => 'right'
                      ]);

                      $this->redirect(['index']);
                  }
                  else
                  {
                      Yii::$app->getSession()->setFlash('danger', [
                         'type' => 'danger',
                         'duration' => 3000,
                         'icon' => 'fa fa-upload',
                         'message' => 'Upload Failed',
                         'title' => 'Notification',
                         'positonY' => 'top',
                         'positonX' => 'right'
                      ]);

                      return $this->render('create', [
                          'service_family' => $service_family,
                      ]);
                  }
              }

              return $this->render('create', [
                      'service_family' => $service_family,
                  ]);
          } else {
              Yii::$app->getSession()->setFlash('danger', [
                     'type' => 'danger',
                     'duration' => 3000,
                     'message' => "It's not your schedule",
                     'title' => 'Notification',
                     'positonY' => 'top',
                     'positonX' => 'right'
              ]);

              return $this->redirect(['index']);
          }  
        }
        
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

        $size = Yii::$app->getDb()->createCommand('SELECT COUNT(*) AS total FROM dm_report')->queryAll();
        $next_id = ((int) $size[0]['total']) + 1;
        Yii::$app->getDb()->createCommand('ALTER TABLE dm_report AUTO_INCREMENT = :id', [':id' => $next_id])->execute();

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
