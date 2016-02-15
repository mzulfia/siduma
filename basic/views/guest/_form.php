<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Guest */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="guest-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'guest_nip')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'guest_name')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'importance')->textarea(['rows' => 6]) ?>

<!--     <?= $form->field($model, 'in_time')->textInput() ?>

    <?= $form->field($model, 'out_time')->textInput() ?>
 -->
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
