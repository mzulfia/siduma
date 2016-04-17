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
               'only' => ['index','create', 'update', 'delete', 'viewschedule', 'viewmyschedule', 'viewactiveall', 'remove', 'deletebydate'],
               'rules' => [
                       [
                           'actions' => ['index','create', 'update', 'delete', 'viewschedule', 'remove', 'deletebydate'],
                           'allow' => true,
                           'roles' => [
                               User::ROLE_ADMINISTRATOR, 
                               User::ROLE_SUPERVISOR
                           ],
                       ],
                       [
                           'actions' => ['viewschedule', 'viewactive'],
                           'allow' => true,
                           'roles' => [
                               User::ROLE_MANAGEMENT
                           ],
                       ],
                       [
                           'actions' => ['viewschedule', 'viewmyschedule', 'viewactive'],
                           'allow' => true,
                           'roles' => [
                               User::ROLE_SUPPORT
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
        if(Yii::$app->request->post()){
            $date_start = explode(" - ", $_POST['Schedule']['date'])[0];
            $date_end = explode(" - ", $_POST['Schedule']['date'])[1];

            $schedules = Schedule::find()->where('date >= :date_start AND date <= :date_end', [':date_start' => $date_start, ':date_end' => $date_end])->all();
            
            for($i = 0; $i < sizeof($schedules); $i++){
                $schedule = $this->findModel($schedules[$i]->schedule_id);
                if($schedule->deleteFile()){
                  $schedule->delete();
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

            $size = Yii::$app->getDb()->createCommand('SELECT COUNT(*) AS total FROM schedule')->queryAll();
            $next_id = ((int) $size[0]['total']) + 1;
            Yii::$app->getDb()->createCommand('ALTER TABLE schedule ALGORITHM=COPY, AUTO_INCREMENT = :id', [':id' => $next_id])->execute();


            Yii::$app->getSession()->setFlash('success', [
               'type' => 'success',
               'duration' => 3000,
               'message' => 'Delete Success',
               'title' => 'Notification',
               'positonY' => 'top',
               'positonX' => 'right'
            ]);    
            
            return $this->redirect(['index']);
        } else{
            $model = new Schedule();
            $searchModel = new ScheduleSearch();
            $searchModel->date = date('Y-m-d'). ' - ' . date('Y-m-d');
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
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

                $rowData = $sheet->rangeToArray('A5'.':'.$highestColumn.'5',NULL,TRUE,FALSE);
                
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
                            while($col < sizeof($rowData[0])){
                                if(!empty(trim($rowData[0][$col]))){
                                    array_push($date, trim($rowData[0][$col])); 

                                    $col = $col + 2;
                                } else{
                                    $col = sizeof($rowData[0]);
                                }
                            }
                        } 
                        else
                        {
                            // insert is_dm
                            $col = 3;
                            $max = (sizeof($date)*2)+1;
                            while($col <= $max){
                                if(trim($rowData[0][$col]) == 'v'){
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
                                    array_push($shift, trim($rowData[0][$col]));
                                }
                                $col = $col + 2;
                            }

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
                                                if(Schedule::getIsNotExist($model->date, $model->shift_id, $model->support_id)){
                                                    if(Schedule::getIsNotExistDM($model->date, $model->shift_id) == 0){
                                                        if($model->save(false))
                                                        {
                                                            Yii::$app->getSession()->setFlash('success', [
                                                                 'type' => 'success',
                                                                 'duration' => 3000,
                                                                 'icon' => 'fa fa-upload',
                                                                 'message' => 'Upload Success',
                                                                 'title' => 'Notification',
                                                                 'positonY' => 'top',
                                                                 'positonX' => 'right'
                                                             ]);    
                                                            
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
                                                                                                                   }   
                                                    }
                                                    elseif(Schedule::getIsNotExistDM($model->date, $model->shift_id) == 1)
                                                    {
                                                        if($model->is_dm == 0)
                                                        {
                                                            if($model->save(false))
                                                            {
                                                                Yii::$app->getSession()->setFlash('success', [
                                                                     'type' => 'success',
                                                                     'duration' => 3000,
                                                                     'icon' => 'fa fa-upload',
                                                                     'message' => 'Upload Success',
                                                                     'title' => 'Notification',
                                                                     'positonY' => 'top',
                                                                     'positonX' => 'right'
                                                                 ]);    
                                                                
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

                                                            }   
                                                        }
                                                        else
                                                        {
                                                            Yii::$app->getSession()->setFlash('danger', [
                                                                 'type' => 'danger',
                                                                 'duration' => 3000,
                                                                 'icon' => 'fa fa-calendar',
                                                                 'message' => 'Duplicate Duty Manager in one shift',
                                                                 'title' => 'Notification',
                                                                 'positonY' => 'top',
                                                                 'positonX' => 'right'
                                                            ]);

                                                        }
                                                    }
                                                    else
                                                    {
                                                        Yii::$app->getSession()->setFlash('danger', [
                                                             'type' => 'danger',
                                                             'duration' => 3000,
                                                             'icon' => 'fa fa-calendar',
                                                             'message' => 'Duplicate Duty Manager in one shift',
                                                             'title' => 'Notification',
                                                             'positonY' => 'top',
                                                             'positonX' => 'right'
                                                        ]);
                                                    }    
                                                } else {
                                                    Yii::$app->getSession()->setFlash('danger', [
                                                         'type' => 'danger',
                                                         'duration' => 3000,
                                                         'icon' => 'fa fa-calendar',
                                                         'message' => 'Duplicate Support in one time',
                                                         'title' => 'Notification',
                                                         'positonY' => 'top',
                                                         'positonX' => 'right'
                                                    ]);
                                                }
                                            } catch(\yii\base\Exception $e){
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
                                            if(Schedule::getIsNotExist($model->date, $model->shift_id, $model->support_id)){
                                                 if(Schedule::getIsNotExistDM($model->date, $model->shift_id) == 0){
                                                    if($model->save(false))
                                                    {
                                                        Yii::$app->getSession()->setFlash('success', [
                                                             'type' => 'success',
                                                             'duration' => 3000,
                                                             'icon' => 'fa fa-upload',
                                                             'message' => 'Upload Success',
                                                             'title' => 'Notification',
                                                             'positonY' => 'top',
                                                             'positonX' => 'right'
                                                         ]);    
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
                                                    }   
                                                }
                                                elseif(Schedule::getIsNotExistDM($model->date, $model->shift_id) == 1)
                                                {
                                                    if($model->is_dm == 0)
                                                    {
                                                        if($model->save(false))
                                                        {
                                                            Yii::$app->getSession()->setFlash('success', [
                                                                 'type' => 'success',
                                                                 'duration' => 3000,
                                                                 'icon' => 'fa fa-upload',
                                                                 'message' => 'Upload Success',
                                                                 'title' => 'Notification',
                                                                 'positonY' => 'top',
                                                                 'positonX' => 'right'
                                                             ]);
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
                                                        }   
                                                    }
                                                    else
                                                    {
                                                        Yii::$app->getSession()->setFlash('danger', [
                                                             'type' => 'danger',
                                                             'duration' => 3000,
                                                             'icon' => 'fa fa-calendar',
                                                             'message' => 'Duplicate Duty Manager in one shift',
                                                             'title' => 'Notification',
                                                             'positonY' => 'top',
                                                             'positonX' => 'right'
                                                        ]);
                                                    }
                                                }
                                                else
                                                {
                                                    Yii::$app->getSession()->setFlash('danger', [
                                                         'type' => 'danger',
                                                         'duration' => 3000,
                                                         'icon' => 'fa fa-calendar',
                                                         'message' => 'Duplicate Duty Manager in one shift',
                                                         'title' => 'Notification',
                                                         'positonY' => 'top',
                                                         'positonX' => 'right'
                                                    ]);
                                                }    
                                            } else {
                                                Yii::$app->getSession()->setFlash('danger', [
                                                     'type' => 'danger',
                                                     'duration' => 3000,
                                                     'icon' => 'fa fa-calendar',
                                                     'message' => 'Duplicate Support in one time',
                                                     'title' => 'Notification',
                                                     'positonY' => 'top',
                                                     'positonX' => 'right'
                                                ]);
                                            }   
                                        } catch(\yii\base\Exception $e){
                                           Yii::$app->getSession()->setFlash('danger', [
                                                 'type' => 'danger',
                                                 'duration' => 3000,
                                                 'icon' => 'fa fa-upload',
                                                 'message' => 'Wrong Format',
                                                 'title' => 'Upload Failed',
                                                 'positonY' => 'top',
                                                 'positonX' => 'right'
                                            ]);
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
            if(Schedule::getIsNotExist($model->date, $model->shift_id, $model->support_id)){
                if(Schedule::getIsNotExistDM($model->date, $model->shift_id) == 0){
                    if($model->save(false))
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
                        return $this->render('update', [
                            'model' => $model,
                        ]);
                    }   
                }
                elseif(Schedule::getIsNotExistDM($model->date, $model->shift_id) == 1)
                {
                    if($model->is_dm == 0)
                    {
                        if($model->save(false))
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
                            return $this->render('update', [
                                'model' => $model,
                            ]);
                        }   
                    }
                    else
                    {
                        Yii::$app->getSession()->setFlash('danger', [
                             'type' => 'danger',
                             'duration' => 3000,
                             'icon' => 'fa fa-calendar',
                             'message' => 'Duplicate Duty Manager in one shift',
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
                    Yii::$app->getSession()->setFlash('danger', [
                         'type' => 'danger',
                         'duration' => 3000,
                         'icon' => 'fa fa-calendar',
                         'message' => 'Duplicate Duty Manager in one shift',
                         'title' => 'Notification',
                         'positonY' => 'top',
                         'positonX' => 'right'
                    ]);

                    return $this->render('update', [
                        'model' => $model,
                    ]);
                }    
            } else {
                Yii::$app->getSession()->setFlash('danger', [
                     'type' => 'danger',
                     'duration' => 3000,
                     'icon' => 'fa fa-calendar',
                     'message' => 'Duplicate Support in one time',
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
        $is_dm = $model->is_dm;
        if ($model->load(Yii::$app->request->post())) {
            if(Schedule::getIsNotExistDM($model->date, $model->shift_id) == 0){
                if($model->save(false))
                {
                    Yii::$app->getSession()->setFlash('success', [
                         'type' => 'success',
                         'duration' => 3000,
                         'icon' => 'fa fa-calendar',
                         'message' => 'Update Success',
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
                         'message' => 'Update Failed',
                         'title' => 'Notification',
                         'positonY' => 'top',
                         'positonX' => 'right'
                     ]);    
                    return $this->render('update', [
                        'model' => $model,
                    ]);
                }   
            }
            elseif(Schedule::getIsNotExistDM($model->date, $model->shift_id) == 1)
            {
                if($model->is_dm == 0 || $is_dm == 1)
                {
                    if($model->save(false))
                    {
                        Yii::$app->getSession()->setFlash('success', [
                             'type' => 'success',
                             'duration' => 3000,
                             'icon' => 'fa fa-calendar',
                             'message' => 'Update Success',
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
                             'message' => 'Update Failed',
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
                    Yii::$app->getSession()->setFlash('danger', [
                         'type' => 'danger',
                         'duration' => 3000,
                         'icon' => 'fa fa-calendar',
                         'message' => 'Duplicate Duty Manager in one shift',
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
                Yii::$app->getSession()->setFlash('danger', [
                     'type' => 'danger',
                     'duration' => 3000,
                     'icon' => 'fa fa-calendar',
                     'message' => 'Duplicate Duty Manager in one shift',
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
            
            $tasks[] = $event;
        }

        return $this->render('viewschedule', [
            'events' => $tasks,
        ]);
    }

    public function actionViewmyschedule($id){
        if(User::getSupportId(Yii::$app->user->getId()) == $id){
            $schedules = Schedule::find()->where('support_id = :id', [':id' => $id])->all();
        
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
                
                $tasks[] = $event;
            }

            return $this->render('viewmyschedule', [
                'events' => $tasks,
            ]);
        } else {
            return $this->redirect(['viewmyschedule', 'id' => User::getSupportId(Yii::$app->user->getId())]);    
        }
    }

    public function actionRemove()
    {   if(Yii::$app->request->isAjax)
        {
            $checkedIDs=$_POST['checked'];
            foreach($checkedIDs as $id){
                $model = $this->findModel($id);
                if($model->deleteFile()){
                  $model->delete();
                } 
            }

            $size = Yii::$app->getDb()->createCommand('SELECT COUNT(*) AS total FROM schedule')->queryAll();
            $next_id = ((int) $size[0]['total']) + 1;
            Yii::$app->getDb()->createCommand('ALTER TABLE schedule ALGORITHM=COPY, AUTO_INCREMENT = :id', [':id' => $next_id])->execute();
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
       $model = $this->findModel($id);
        if($model->deleteFile()){
          $model->delete();
          
          $size = Yii::$app->getDb()->createCommand('SELECT COUNT(*) AS total FROM schedule')->queryAll();
          $next_id = ((int) $size[0]['total']) + 1;
          Yii::$app->getDb()->createCommand('ALTER TABLE schedule ALGORITHM=COPY, AUTO_INCREMENT = :id', [':id' => $next_id])->execute();

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