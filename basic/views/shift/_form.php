<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\time\TimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Shift */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shift-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'shift_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shift_start')->widget(TimePicker::classname(), [
	    'name' => 't1',
	    'pluginOptions' => [
		    'showSeconds' => true,
		    'showMeridian' => false,
		    'minuteStep' => 1,
		    'secondStep' => 5,
    	],
	    'addonOptions' => [
	        'asButton' => true,
	        'buttonOptions' => ['class' => 'btn btn-info']
	    ]
	]); ?>

    <?= $form->field($model, 'shift_end')->widget(TimePicker::classname(), [
	    'name' => 't2',
	    'pluginOptions' => [
		    'showSeconds' => true,
		    'showMeridian' => false,
		    'minuteStep' => 1,
		    'secondStep' => 5,
    	],
	    'addonOptions' => [

	        'asButton' => true,
	        'buttonOptions' => ['class' => 'btn btn-info']
	    ]
	]);?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
