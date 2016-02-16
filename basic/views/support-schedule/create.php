<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SupportSchedule */

$this->title = 'Create Support Schedule';
$this->params['breadcrumbs'][] = ['label' => 'Support Schedules', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="support-schedule-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
