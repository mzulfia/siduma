<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

use app\models\Schedule;


/* @var $this yii\web\View */
/* @var $searchModel app\models\ScheduleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Schedules';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schedule-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Schedule', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
        // Modal::begin([
        //     'header' => '<h4>Schedule</h4>',
        //     'id' => 'modal',
        //     'size' => 'modal-lg'
        // ]);

        // echo "<div id='modalContent'></div>";

        // Modal::end(); 
    ?>

    

    <?php
        // $positions = sizeof(Schedule::getListPosName());
        // for($i = 0; $i < $positions; $i++){
    ?>        
       
    

      <!-- Html::a('Create Schedule', ['create'], ['class' => 'btn btn-success']);
        }
        // Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])
        // Html::submitButton('label', ['/controller/action'], ['class'=>'btn btn-primary']);
        // foreach(Schedule::getListPosName() as $position){
        //     Html::a($position, ['/schedule/viewposition', ['position' => $position]], ['class'=>'btn btn-primary']);
        // } -->
   
   <?= 


   // \yii2fullcalendar\yii2fullcalendar::widget(array(
   //      'events'=> $events, 
   //      ));


     GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'schedule_id',
            'date',
            'shift_id',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
