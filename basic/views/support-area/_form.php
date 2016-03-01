<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SupportArea */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="support-area-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'support_id')->textInput() ?>

    <?= $form->field($model, 'service_family_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
