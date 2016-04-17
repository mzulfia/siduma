<?php

namespace app\controllers;

use Yii;
use app\models\DmReport;
use app\models\DmReportSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use app\components\AccessRules;
use yii\filters\AccessControl;

use kartik\mpdf\Pdf;

use app\models\User;
use app\models\Shift;
use app\models\Schedule;
use app\models\Support;
use app\models\ServiceFamily;


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
               'only' => ['index','create', 'update', 'delete', 'view', 'exportReport'],
               'rules' => [
                       [
                           'actions' => ['index', 'create', 'update', 'delete', 'exportReport'],
                           'allow' => true,
                           'roles' => [
                               User::ROLE_ADMINISTRATOR, 
                           ],
                       ],
                       [
                           'actions' => ['index', 'create', 'update', 'exportReport'],
                           'allow' => true,
                           'roles' => [
                               User::ROLE_SUPPORT,
                           ],
                       ],
                       [
                           'actions' => ['index', 'exportReport'],
                           'allow' => true,
                           'roles' => [
                               User::ROLE_MANAGEMENT,
                               User::ROLE_SUPERVISOR,
                           ],
                       ],
                       [
                           'actions' => ['view'],
                           'allow' => true,
                           'roles' => ['@'],
                       ]
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
            $searchModel->created_at = date('Y-m-d'). ' - ' . date('Y-m-d');
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } elseif(User::getRoleId(Yii::$app->user->getId()) == User::ROLE_MANAGEMENT || User::getRoleId(Yii::$app->user->getId()) == User::ROLE_SUPERVISOR) {
            $searchModel = new DmReportSearch();
            $searchModel->created_at = date('Y-m-d'). ' - ' . date('Y-m-d');
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('indexMgtSpv', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
          date_default_timezone_set("Asia/Jakarta");
          if(Schedule::getIsDmNow(date('Y-m-d'), Shift::getShift(date("H:i:s"))->shift_id, User::getSupportId(Yii::$app->user->getId()))) {
              $support_id = User::getSupportId(Yii::$app->user->getId());
              $searchModel = new DmReportSearch();
              $searchModel->support_id = $support_id;
              $searchModel->created_at = date('Y-m-d'). ' - ' . date('Y-m-d');
              $dataProvider = $searchModel->searchDmReports(Yii::$app->request->queryParams);

              return $this->render('indexUnauthorized', [
                  'searchModel' => $searchModel,
                  'dataProvider' => $dataProvider,
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

              return $this->goBack();
          }  
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
            } else {
                  return $this->render('create', [
                      'service_family' => $service_family,
                  ]);
            }
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
              } else {
                  return $this->render('create', [
                      'service_family' => $service_family,
                  ]);
              }
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

        if(User::getRoleId(Yii::$app->user->getId()) == User::ROLE_SUPPORT){
          if($model->support_id == User::getSupportId(Yii::$app->user->getId())){
            if ($model->load(Yii::$app->request->post())) 
            {
                $model->created_at = date("Y-m-d H:i:s"); 
                $model->file = UploadedFile::getInstance($model, 'file');
                if(!is_null($model->file))
                {
                    $ext =  end((explode(".", $model->file->name)));
                    $filename = $model->file->baseName;
                    if(!empty($model->file_path)){
                        $dm = DmReport::findOne($id);
                        $dm->deleteFile();
                        $model->file_path =  'uploads/reports/dutymanager/' . $filename.".{$ext}";
                        if($model->save()){
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
                        if($model->save()){
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
                    if($model->save()){
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
          } else{
            Yii::$app->getSession()->setFlash('danger', [
                   'type' => 'danger',
                   'duration' => 3000,
                   'message' => "You're not allowed",
                   'title' => 'Notification',
                   'positonY' => 'top',
                   'positonX' => 'right'
            ]);

            return $this->goBack();
          } 
        } else{
          if ($model->load(Yii::$app->request->post())) 
            {
                $model->created_at = date("Y-m-d H:i:s"); 
                $model->file = UploadedFile::getInstance($model, 'file');
                if(!is_null($model->file))
                {
                    $ext =  end((explode(".", $model->file->name)));
                    $filename = $model->file->baseName;
                    if(!empty($model->file_path)){
                        $dm = DmReport::findOne($id);
                        $dm->deleteFile();
                        $model->file_path =  'uploads/reports/dutymanager/' . $filename.".{$ext}";
                        if($model->save()){
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
                        if($model->save()){
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
                    if($model->save()){
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

        $service_family = [];
        for($i=0; $i < sizeof(ServiceFamily::find()->all()); $i++){
            $service_family[$i] = [0.0, 0.0, 0.0];
        }

        $date = date('Y-m-d'). ' - ' . date('Y-m-d');
        if(isset($_POST['report-button']) && $_POST['Schedule']['date'] != ''){
            $date = $_POST['Schedule']['date'];
            for($i = 0; $i < sizeof($service_family); $i++){
                $service_family[$i][0] = (float) number_format((float)DmReport::getNormalCondition($date, $i+1), 2, '.', '');
                $service_family[$i][1] = (float) number_format((float)DmReport::getWarningCondition($date, $i+1), 2, '.', '');
                $service_family[$i][2] = (float) number_format((float)DmReport::getCriticalCondition($date, $i+1), 2, '.', '');
            }
        }        

        return $this->render('reportHistory', [
            'model' => $model,
            'date' => $date,
            'service_family' => $service_family
        ]);    
    }

    public function actionExportreport(){
      if(User::getRoleId(Yii::$app->user->getId()) == User::ROLE_SUPPORT)
        {
            if(Schedule::getIsDmNow(date('Y-m-d'), Shift::getShift(date("H:i:s"))->shift_id, User::getSupportId(Yii::$app->user->getId()))) {
                $date = "";
                $shift_name = "";

                if(!empty(DmReport::getLastUpdated()) && !empty(DmReport::getLastUpdated())){
                  $date = date("d-F-Y", strtotime(explode(" ", DmReport::getLastUpdated()->created_at)[0]));
                  $shift_name = Shift::getShift(explode(" ", DmReport::getLastUpdated()->created_at)[1])->shift_name;
                }

                $pdf = new Pdf([
                    'content' => $this->renderPartial('exportReport'),
                    'options' => [
                        'title' => 'Duty Manager Report on '. $date . " " . $shift_name,
                        'subject' => 'Generating PDF files via yii2-mpdf extension has never been easy'
                    ],
                    'methods' => [
                        'SetHeader' => ['Generated On: ' . date("r")],
                    ]
                ]);
                $pdf->filename = "DUMA Report_" . $date . "_" . $shift_name .".pdf";
                return $pdf->render();
            } else {
                Yii::$app->getSession()->setFlash('danger', [
                       'type' => 'danger',
                       'duration' => 3000,
                       'message' => "It's not your schedule",
                       'title' => 'Notification',
                       'positonY' => 'top',
                       'positonX' => 'right'
                ]);

                return $this->goBack();
            }  
        } else{
          $date = "";
          $shift_name = "";

          if(!empty(DmReport::getLastUpdated()) && !empty(DmReport::getLastUpdated())){
            $date = date("d-F-Y", strtotime(explode(" ", DmReport::getLastUpdated()->created_at)[0]));
            $shift_name = Shift::getShift(explode(" ", DmReport::getLastUpdated()->created_at)[1])->shift_name;
          }

          $pdf = new Pdf([
              'content' => $this->renderPartial('exportReport'),
              'options' => [
                  'title' => 'Duty Manager Report on '. $date . " " . $shift_name,
                  'subject' => 'Generating PDF files via yii2-mpdf extension has never been easy'
              ],
              'methods' => [
                  'SetHeader' => ['Generated On: ' . date("r")],
              ]
          ]);

          
          $pdf->filename = "DUMA Report_" . $date . "_" . $shift_name .".pdf";
          return $pdf->render();
        }
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
        if($model->delete()){
          $size = Yii::$app->getDb()->createCommand('SELECT COUNT(*) AS total FROM dm_report')->queryAll();
          $next_id = ((int) $size[0]['total']) + 1;
          Yii::$app->getDb()->createCommand('ALTER TABLE dm_report ALGORITHM=COPY, AUTO_INCREMENT = :id', [':id' => $next_id])->execute();

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
