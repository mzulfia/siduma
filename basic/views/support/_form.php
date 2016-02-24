<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use app\models\SupportPosition;
/* @var $this yii\web\View */
/* @var $model app\models\Pic */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="support-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'support_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_hp')->textInput() ?>

    <?= $form->field($model, 'email')->textInput() ?>

    <?= $form->field($model, 'support_position_id')->dropDownList(ArrayHelper::map(SupportPosition::find()->all(), 'support_position_id', 'position_name'), ['prompt'=>'-Select Position-']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
