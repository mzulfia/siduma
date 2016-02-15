<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Pic */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pic-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pic_nip')->textInput() ?>

    <?= $form->field($model, 'pic_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_hp')->textInput() ?>

    <?= $form->field($model, 'pic_position_id')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
