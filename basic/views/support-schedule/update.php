<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SupportSchedule */

$this->title = 'Update Support Schedule: ' . ' ' . $model->support_schedule_id;
$this->params['breadcrumbs'][] = ['label' => 'Support Schedules', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->support_schedule_id, 'url' => ['view', 'id' => $model->support_schedule_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="support-schedule-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
