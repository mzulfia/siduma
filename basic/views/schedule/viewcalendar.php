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


$this->title = 'Schedules | View Calendar';
$this->params['breadcrumbs'][] = 'Schedules';
?>
<style>
    .legend { list-style: none; }
    .legend li { float: left; margin-right: 10px; }
    .legend span { border: 1px solid #ccc; float: left; width: 12px; height: 12px; margin: 4px; }
    /* your colors */
    .legend .shiftpagi { background-color: #3c8dbc; }
    .legend .shiftsore { background-color: #bc6b3c; }
    .legend .shiftmalam { background-color: #a6004c; }
</style>

<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Schedules</h3>
  </div><!-- /.box-header -->
  <div class="box-body">
    <?= 
        \yii2fullcalendar\yii2fullcalendar::widget(array(
        'events'=> $events, 
        ));
    ?>
    <br>
    <ul class="legend">
        <li><span class="shiftpagi"></span> Shift Pagi</li>
        <li><span class="shiftsore"></span> Shift Sore</li>
        <li><span class="shiftmalam"></span> Shift Malam</li>
    </ul>
  </div>
</div>
  


