<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SupportScheduleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="support-schedule-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'support_schedule_id') ?>

    <?= $form->field($model, 'support_id') ?>

    <?= $form->field($model, 'schedule_id') ?>

    <?= $form->field($model, 'is_pic') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
