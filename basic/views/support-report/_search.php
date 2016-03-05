<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ReportSupportSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="report-support-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'support_report_id') ?>

    <?= $form->field($model, 'information') ?>

    <?= $form->field($model, 'file_path') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'support_id') ?>

    <?php // echo $form->field($model, 'service_family_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
