<?php

namespace app\controllers;

use Yii;
use app\models\SupportReport;
use app\models\SupportReportSearch;
use app\models\User;
use app\models\Shift;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;


/**
 * SupportReportController implements the CRUD actions for SupportReport model.
 */
class SupportReportController extends Controller
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
     * Lists all SupportReport models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(User::getRoleId(Yii::$app->user->getId()) == User::ROLE_ADMINISTRATOR){
            $searchModel = new SupportReportSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else{
            $support_id = User::getSupportId(Yii::$app->user->getId());
            $searchModel = new SupportReportSearch();
            $searchModel->support_id =  $support_id;
            $dataProvider = $searchModel->searchSupportReports(Yii::$app->request->queryParams);

            return $this->render('indexUnauthorized', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);

        }
    }

    /**
     * Displays a single SupportReport model.
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
     * Creates a new SupportReport model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SupportReport();

        $post = Yii::$app->request->post();

        if($model->load($post)){
            date_default_timezone_set("Asia/Jakarta");
            $model->created_at = date("Y-m-d H:i:s"); 
            $model->support_id = User::getSupportId(Yii::$app->user->getId());

            $array = SupportReport::getServiceSupportReport($model->service_family_id);
            if(!empty($array)){
                if(explode(" ", $model->created_at)[0] == explode(" ", $array->created_at)[0] && Shift::getShift(explode(" ", $model->created_at)[1])->shift_id == Shift::getShift(explode(" ", $array->created_at)[1])->shift_id){
                    Yii::$app->getSession()->setFlash('danger', [
                       'type' => 'danger',
                       'duration' => 3000,
                       'icon' => 'fa fa-file',
                       'message' => 'Report has been submitted by someone',
                       'title' => 'Notification',
                       'positonY' => 'top',
                       'positonX' => 'right'
                    ]);
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }
                else
                {
                    $file_upload = UploadedFile::getInstance($model, 'file');
                    if(!empty($file_upload)){
                        $model->file = $file_upload;
                        $model->file->saveAs('uploads/reports/support/' . $model->file->baseName . '.' . $model->file->extension);    
                        $model->file_path = 'uploads/reports/support/' . $model->file->baseName . '.' . $model->file->extension;
                        $model->save();
                        
                        return $this->redirect(['index']);
                    } else {
                        return $this->render('create', [
                            'model' => $model,
                        ]);
                    }
                } 
            } else {
                $file_upload = UploadedFile::getInstance($model, 'file');
                if(!empty($file_upload)){
                    $model->file = $file_upload;
                    $model->file->saveAs('uploads/reports/support/' . $model->file->baseName . '.' . $model->file->extension);    
                    $model->file_path = 'uploads/reports/support/' . $model->file->baseName . '.' . $model->file->extension;
                    $model->save();
                     return $this->redirect(['index']);
                } else {
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SupportReport model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $array = SupportReport::getServiceSupportReport($model->service_family_id);
            if(!empty($array)){
                if(explode(" ", $model->created_at)[0] == explode(" ", $array->created_at)[0] && Shift::getShift(explode(" ", $model->created_at)[1])->shift_id == Shift::getShift(explode(" ", $array->created_at)[1])->shift_id){
                    $model->file = UploadedFile::getInstance($model, 'file');
                    $ext =  end((explode(".", $model->file->name)));
                    $filename = $model->file->baseName;
                    if(!empty($model->file_path)){
                        $support = SupportReport::findOne($id);
                        $support->deleteFile();
                        $model->file_path =  'uploads/reports/support/' . $filename.".{$ext}";
                        if($model->update()){
                            $model->file->saveAs('uploads/reports/support/' . $filename .".{$ext}");   

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
                               'message' => 'Download Failed',
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
                        $model->file_path =  'uploads/reports/support/' . $filename.".{$ext}";
                        if($model->update()){
                            $model->file->saveAs('uploads/reports/support/' . $filename .".{$ext}");   

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
                        } else{
                            Yii::$app->getSession()->setFlash('danger', [
                               'type' => 'danger',
                               'duration' => 3000,
                               'icon' => 'fa fa-upload',
                               'message' => 'Download Failed',
                               'title' => 'Notification',
                               'positonY' => 'top',
                               'positonX' => 'right'
                            ]);
                            return $this->render('update', [
                                'model' => $model,
                            ]);
                        } 
                    }
                } else{
                    Yii::$app->getSession()->setFlash('danger', [
                       'type' => 'danger',
                       'duration' => 3000,
                       'icon' => 'fa fa-file',
                       'message' => 'Report has been submitted by someone',
                       'title' => 'Notification',
                       'positonY' => 'top',
                       'positonX' => 'right'
                    ]);
                    return $this->render('update', [
                        'model' => $model,
                    ]);
                } 
            }
        } else {
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

    /**
     * Deletes an existing SupportReport model.
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
     * Finds the SupportReport model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SupportReport the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SupportReport::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
