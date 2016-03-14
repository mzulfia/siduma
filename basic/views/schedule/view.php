<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Schedule */

$this->title = 'Schedules | View Schedule';
$this->params['breadcrumbs'][] = ['label' => 'Schedules', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'View Schedule';
?>
<div class="schedule-view">

    <h1>View Schedule</h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->schedule_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->schedule_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'schedule_id',
            'date',
            'shift_id',
        ],
    ]) ?>

</div>
