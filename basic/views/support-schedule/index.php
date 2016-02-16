<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SupportScheduleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Support Schedules';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="support-schedule-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Support Schedule', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'support_schedule_id',
            'support_id',
            'schedule_id',
            'is_pic',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
