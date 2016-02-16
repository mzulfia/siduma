<?php

namespace app\controllers;

use Yii;
use app\models\Schedule;
use app\models\ScheduleSearch;
use app\models\Pic;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
        $schedules = Schedule::find()->all();
        $searchModel = new ScheduleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $tasks = [];

        foreach($schedules as $schedule){
            $event = new  \yii2fullcalendar\models\Event();
            $event->id = $schedule->schedule_id;
            $event->title = Schedule::getPicName($schedule->pic_id);
            $event->start = date('Y-m-d\Th:i:s\Z',strtotime($schedule->date.' '.$schedule->shift_start));
            $event->end = date('Y-m-d\Th:i:s\Z',strtotime($schedule->date.' '.$schedule->shift_end));
            $event->editable = true;
            $event->allDay = false;
            $event->startEditable = true;
            $event->durationEditable = true;
            $tasks[] = $event;
        }
        // $searchModel = new ScheduleSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'events' => $tasks,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            // 'searchModel' => $searchModel,
            // 'dataProvider' => $dataProvider,
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
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->schedule_id]);
        } else {
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

    public function actionViewpic($date)
    {
        $searchModel = new ScheduleSearch();
        $searchModel->date = $date;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('viewPIC', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewposition($position)
    {
        $schedules = Schedule::find()->all();

        $tasks = [];

        foreach($schedules as $schedule){
            $event = new  \yii2fullcalendar\models\Event();
            $event->id = $schedule->schedule_id;
            $event->title = Schedule::getPicName($schedule->pic_id);
            $event->start = date('Y-m-d\Th:i:s\Z',strtotime($schedule->date.' '.$schedule->shift_start));
            $event->end = date('Y-m-d\Th:i:s\Z',strtotime($schedule->date.' '.$schedule->shift_end));
            $event->editable = true;
            $event->allDay = false;
            $event->startEditable = true;
            $event->durationEditable = true;
            $tasks[] = $event;

        }
        // $searchModel = new ScheduleSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'events' => $tasks,
            // 'searchModel' => $searchModel,
            // 'dataProvider' => $dataProvider,
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
