<?php

namespace app\controllers;

use Yii;
use app\models\Schedule;
use app\models\ScheduleSearch;
use app\models\Pic;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\Support;
/**
 * ScheduleController implements the CRUD actions for Schedule model.
 */
class ScheduleController extends Controller
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
     * Lists all Schedule models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new ScheduleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Schedule model.
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
     * Creates a new Schedule model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Schedule();
        
        if(isset($_POST['automatic-button']))
        {
            $model->load(Yii::$app->request->post());
            $model->file = UploadedFile::getInstance($model, 'file');
            $model->file->saveAs('uploads/schedules/' . $model->file->baseName . '.' . $model->file->extension);
            $inputFile = 'uploads/schedules/' . $model->file->baseName . '.' . $model->file->extension;

            try{
                $inputFileType = \PHPExcel_IOFactory::identify($inputFile);
                $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFile);
            } 
            catch(Exception $e)
            {
                die('Error');
            }

            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            $date = [];
            for($row = 2; $row <= $highestRow; $row++)
            {
                $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);
                if($row == 2)
                {   
                    for($col = 1; $col <= 31; $col++)
                    {
                        if($rowData[0][$col] != '-')
                        {
                            array_push($date, $rowData[0][$col]);
                        }
                        else
                        {
                            $col = 31;
                        }
                    }
                } 
                else
                {
                    // var_dump(Support::find()->where('support_name LIKE :support_name', [':support_name' => $rowData[0][0]])->one());

                    for($col = 0; $col < sizeof($date); $col++)
                    {   
                        $model= new Schedule();
                        $support = Support::find()->where('support_name LIKE :support_name', [':support_name' => $rowData[0][0]])->one();
                        $model->support_id = $support['support_id'];
                        if($col < sizeof($date)  && ($rowData[0][$col+1] != '-' && $rowData[0][$col+1] != 0))
                        {
                            $model->file_path = $inputFile;
                            $model->date = $date[$col];
                            $model->shift_id = $rowData[0][$col+1];
                            $model->save(false);
                        }
                    }
                }        
            }
            // var_dump($date);
            Yii::$app->getSession()->setFlash('success', [
                 'type' => 'success',
                 'duration' => 3000,
                 'icon' => 'fa fa-upload',
                 'message' => 'Upload Success',
                 'title' => 'Notification',
                 'positonY' => 'top',
                 'positonX' => 'right'
             ]);
             return $this->redirect(['create']);
        }  
        elseif(isset($_POST['manual-button']))
        {
            $model->load(Yii::$app->request->post());
            $model->save();
            Yii::$app->getSession()->setFlash('success', [
                 'type' => 'success',
                 'duration' => 3000,
                 'icon' => 'fa fa-calendar',
                 'message' => 'Create Success',
                 'title' => 'Notification',
                 'positonY' => 'top',
                 'positonX' => 'right'
             ]);
            return $this->redirect(['index']);
        }
        else if(isset($_POST['setdm-button']))
        {
            $model = new Schedule();

            $model->load(Yii::$app->request->post());
            $date = explode(" - ", $model->date[1]);
            $start = $date[0];
            $end = $date[1];
            Schedule::setDM($start, $end, $model->shift_id);

            Yii::$app->getSession()->setFlash('success', [
                 'type' => 'success',
                 'duration' => 3000,
                 'icon' => 'fa fa-user',
                 'message' => 'Generate DM Success',
                 'title' => 'Notification',
                 'positonY' => 'top',
                 'positonX' => 'right'
             ]);
            return $this->redirect(['index']);
            return $this->redirect(['index']);
        }
        else 
        {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Schedule model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->schedule_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Schedule model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionViewdm($date)
    {
        $searchModel = new ScheduleSearch();
        $searchModel->date = $date;
        $searchModel->is_dm = 1;
        $dataProvider = $searchModel->searchDM(Yii::$app->request->queryParams);

        return $this->render('viewdm', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewteam($id)
    {
        $searchModel = new ScheduleSearch();
        $schedule = Schedule::findOne($id);
        $searchModel->date = $schedule->date;
        $searchModel->shift_id = $schedule->shift_id;
        $dataProvider = $searchModel->searchTeam(Yii::$app->request->queryParams);

        return $this->renderAjax('viewteam', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewschedule(){
        $schedules = Schedule::find()->where('is_dm = 1')->all();
        
        $tasks = [];

        foreach($schedules as $schedule){
            $event = new  \yii2fullcalendar\models\Event();
            $event->id = $schedule->schedule_id;
            $event->title = Schedule::getSupportName($schedule->support_id);
            $event->start = date('Y-m-d\TH:i:s\Z',strtotime($schedule->date.' '.Schedule::getShiftStart($schedule->shift_id)));
            $event->end = date('Y-m-d\TH:i:s\Z',strtotime($schedule->date.' '.Schedule::getShiftEnd($schedule->shift_id)));
            if($schedule->shift_id == 1){
                $event->color = '#3c8dbc';
            } elseif($schedule->shift_id == 2){
                $event->color = '#bc6b3c';
            } else{
                $event->color = '#a6004c';
            }
            // $event->editable = true;
            // $event->startEditable = true;
            // $event->allDay = true;
            // $event->durationEditable = true;
            $tasks[] = $event;
        }

        return $this->render('viewschedule', [
            'events' => $tasks,
        ]);
    }

    /**
     * Finds the Schedule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Schedule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Schedule::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
