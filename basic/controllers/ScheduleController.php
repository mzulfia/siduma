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
use app\models\User;
use app\components\AccessRules;
use yii\filters\AccessControl;

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
            'access' => [
               'class' => AccessControl::className(),
               'ruleConfig' => [
                   'class' => AccessRules::className(),
               ],
               'only' => ['index','create', 'update', 'delete', 'viewcalendar'],
               'rules' => [
                       [
                           'actions' => ['index','create', 'update', 'delete', 'viewcalendar'],
                           'allow' => true,
                           'roles' => [
                               User::ROLE_ADMINISTRATOR, 
                           ],
                       ],
                       [
                           'actions' => ['index', 'create', 'update', 'viewcalendar'],
                           'allow' => true,
                           'roles' => [
                               User::ROLE_SUPERVISOR,
                           ],
                       ],
                       [
                           'actions' => ['index', 'viewcalendar'],
                           'allow' => true,
                           'roles' => [
                               '@'
                           ],
                       ],
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
     * Creates a new Schedule model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Schedule();
        
        if(isset($_POST['automatic-button']))
        {
           try{
                $model->load(Yii::$app->request->post());
                $model->file = UploadedFile::getInstance($model, 'file');
                $model->file->saveAs('uploads/schedules/' . $model->file->baseName . '.' . $model->file->extension);
                $inputFile = 'uploads/schedules/' . $model->file->baseName . '.' . $model->file->extension;
                
                $inputFileType = \PHPExcel_IOFactory::identify($inputFile);
                $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFile);

                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                $content =$highestRow-7;
                
                $date = [];
                for($row = 5; $row <= $content; $row++)
                {
                    $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);
                    
                    if(!empty($rowData[0][0]))
                    {
                        $is_dm = [];
                        $shift = [];    

                        if($row == 5)
                        {   
                            $col = 2;
                            while($col <= 63){
                                if(!empty($rowData[0][$col])){
                                    array_push($date, $rowData[0][$col]); 
                                } else{
                                    $col = 63;
                                }

                                $col = $col + 2;
                            }
                        } 
                        else
                        {
                            // var_dump(Support::find()->where('support_name LIKE :support_name', [':support_name' => $rowData[0][1]])->one());
                            // insert is_dm
                            $col = 3;
                            $max = (sizeof($date)*2)+1;
                            while($col <= $max){
                                if($rowData[0][$col] == 'v'){
                                    array_push($is_dm, 1);
                                } else {
                                    array_push($is_dm, 0);
                                }
                                $col = $col + 2;
                            }

                            // insert shift
                            $col = 2;
                            while($col <= $max){
                                if(trim($rowData[0][$col]) == 'L' || trim($rowData[0][$col]) == '' ){
                                    array_push($shift, NULL);
                                } else {
                                    array_push($shift, $rowData[0][$col]);
                                }
                                $col = $col + 2;
                            }
                            // var_dump($date);
                            // die($inputFile);

                            for($col = 0; $col < sizeof($date); $col++)
                            {   
                                if(!empty($shift[$col])){
                                    if(strlen($shift[$col]) > 1)
                                    {
                                        $no = explode('&', $shift[$col]);
                                        
                                        for($i = 0; $i < sizeof($no); $i++){
                                            $model= new Schedule();
                                            $support = Support::find()->where('upper(support_name) LIKE upper(:support_name)', [':support_name' => trim($rowData[0][1])])->one();
                                            $model->support_id = $support['support_id'];
                                            $model->file_path = $inputFile;
                                            $model->date = $date[$col];
                                            $model->shift_id = (int) $no[$i];
                                            $model->is_dm = $is_dm[$col];
                                            try{
                                                $model->save(false);    
                                            } catch(\yii\db\IntegrityException $e){
                                                Yii::$app->getSession()->setFlash('danger', [
                                                     'type' => 'danger',
                                                     'duration' => 3000,
                                                     'icon' => 'fa fa-upload',
                                                     'message' => 'Wrong Format',
                                                     'title' => 'Upload Failed',
                                                     'positonY' => 'top',
                                                     'positonX' => 'right'
                                                ]);

                                                return $this->redirect(['create']);
                                            }
                                        }
                                    }
                                    else
                                    {
                                        $model= new Schedule();
                                        $support = Support::find()->where('upper(support_name) LIKE upper(:support_name)', [':support_name' => trim($rowData[0][1])])->one();
                                        $model->support_id = $support['support_id'];
                                        $model->file_path = $inputFile;
                                        $model->date = $date[$col];
                                        $model->shift_id = (int) $shift[$col];
                                        $model->is_dm = $is_dm[$col];
                                        try{
                                            $model->save(false);    
                                        } catch(\yii\db\IntegrityException $e){
                                           Yii::$app->getSession()->setFlash('danger', [
                                                 'type' => 'danger',
                                                 'duration' => 3000,
                                                 'icon' => 'fa fa-upload',
                                                 'message' => 'Wrong Format',
                                                 'title' => 'Upload Failed',
                                                 'positonY' => 'top',
                                                 'positonX' => 'right'
                                            ]);

                                            return $this->redirect(['create']);
                                        }
                                    }
                                }
                            }
                        }  
                    }
                    else
                    {
                        $row  = $content;
                    }   
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

                return $this->redirect(['create']);
            } 
            catch(\yii\base\Exception $e)
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
               
                return $this->redirect(['create']);
            }
        }  
        elseif(isset($_POST['manual-button']))
        {
            $model->load(Yii::$app->request->post());
            if($model->save())
            {
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
            else
            {
                Yii::$app->getSession()->setFlash('danger', [
                     'type' => 'danger',
                     'duration' => 3000,
                     'icon' => 'fa fa-calendar',
                     'message' => 'Create Failed',
                     'title' => 'Notification',
                     'positonY' => 'top',
                     'positonX' => 'right'
                 ]);    
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
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

        if ($model->load(Yii::$app->request->post())) {
            if($model->save(false))
            {
                Yii::$app->getSession()->setFlash('success', [
                     'type' => 'success',
                     'duration' => 3000,
                     'icon' => 'fa fa-upload',
                     'message' => 'Update Success',
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
                     'message' => 'Update Failed',
                     'title' => 'Notification',
                     'positonY' => 'top',
                     'positonX' => 'right'
                ]);

                $this->redirect(['index']);   
            }
             
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

        $size = Yii::$app->getDb()->createCommand('SELECT COUNT(*) AS total FROM schedule')->queryAll();
        $next_id = ((int) $size[0]['total']) + 1;
        Yii::$app->getDb()->createCommand('ALTER TABLE schedule AUTO_INCREMENT = :id', [':id' => $next_id])->execute();

        return $this->redirect(['index']);
    }

    public function actionViewactive($date)
    {
        $morning_dm = Schedule::find()->where('date = :date AND shift_id = 1 AND is_dm = 1',[':date' => $date])->all();
        $morning_team = Schedule::find()->where('date = :date AND shift_id = 1 AND is_dm = 0',[':date' => $date])->all();
        $afternoon_dm = Schedule::find()->where('date = :date AND shift_id = 2 AND is_dm = 1', [':date' => $date])->all();
        $afternoon_team = Schedule::find()->where('date = :date AND shift_id = 2 AND is_dm = 0', [':date' => $date])->all();
        $evening_dm = Schedule::find()->where('date = :date AND shift_id = 3 AND is_dm = 1', [':date' => $date])->all();
        $evening_team = Schedule::find()->where('date = :date AND shift_id = 3 AND is_dm = 0', [':date' => $date])->all();
        return $this->render('viewactive', [
            'morning_dm' => $morning_dm,
            'morning_team' => $morning_team,
            'afternoon_dm' => $afternoon_dm,
            'afternoon_team' => $afternoon_team,
            'evening_dm' => $evening_dm,
            'evening_team' => $evening_team,
            'date' => $date
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

    public function actionViewcalendar(){
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

        return $this->render('viewcalendar', [
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
