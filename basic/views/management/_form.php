<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Management */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="management-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'mgt_nip')->textInput() ?>

    <?= $form->field($model, 'mgt_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mgt_position')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
