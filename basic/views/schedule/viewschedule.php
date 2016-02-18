<?php

use yii\helpers\Url;
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
<style>
    .legend { list-style: none; }
    .legend li { float: left; margin-right: 10px; }
    .legend span { border: 1px solid #ccc; float: left; width: 12px; height: 12px; margin: 4px; }
    /* your colors */
    .legend .shiftpagi { background-color: #dd4b39; }
    .legend .shiftsore { background-color: #f39c12; }
    .legend .shiftmalam { background-color: #00a65a; }
</style>


<h1><?= Html::encode($this->title) ?></h1>
<!-- 
    <div style="text-align: center" class="container">
        <div class="row clearfix">
          <div class="col-md-12 column">
            <div class="tabbable" id="tabs-59303">
              <ul class="nav nav-tabs">
                <li class="active">
                    <a href="<?php //echo Url::to(['schedule/morning']); ?>">Shift Pagi</a>
                </li>
                <li>
                    <a href="<?php //echo Url::to(['schedule/afternoon']); ?>">Shift Sore</a>
                </li>
                <li>
                    <a href="<?php //echo Url::to(['schedule/evening']); ?>">Shift Malam</a>
                </li>
              </ul>
        </div>
      </div>
    </div>
  </div> -->

<div class="schedule-index">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
        // Modal::begin([
        //     'header' => '<h4>Schedule</h4>',
        //     'id' => 'modal',
        //     'size' => 'modal-lg'
        // ]);

        // echo "<div id='modalContent'></div>";

        // Modal::end(); 
    ?>

      <!-- Html::a('Create Schedule', ['create'], ['class' => 'btn btn-success']);
        }
        // Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])
        // Html::submitButton('label', ['/controller/action'], ['class'=>'btn btn-primary']);
        // foreach(Schedule::getListPosName() as $position){
        //     Html::a($position, ['/schedule/viewposition', ['position' => $position]], ['class'=>'btn btn-primary']);
        // } -->
   
   <?= 

        // var_dump($events);
        \yii2fullcalendar\yii2fullcalendar::widget(array(
        'events'=> $events, 
        ));

        ?>
</div>

<br>
<ul class="legend">
    <li><span class="shiftpagi"></span> Shift Pagi</li>
    <li><span class="shiftsore"></span> Shift Sore</li>
    <li><span class="shiftmalam"></span> Shift Malam</li>
</ul>
