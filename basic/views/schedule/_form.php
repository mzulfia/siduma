<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\time\TimePicker;
use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $model app\models\Schedule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="schedule-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
  			'name' => 'c1',
  			'options' => 
    		[
    			'placeholder' => 'Select issue date ...',
    		],
    		'pluginOptions' => [
	        	'format' => 'yyyy-mm-dd',
	        	'todayHighlight' => true,
	        	'autoclose' => true,
    		]	
		]) 
	?>

    <?= $form->field($model, 'shift_start')->widget(TimePicker::classname(), [
	    'name' => 't1',
	    'addonOptions' => [
	        'asButton' => true,
	        'buttonOptions' => ['class' => 'btn btn-info']
	    ]
	]); ?>
    <?= $form->field($model, 'shift_end')->widget(TimePicker::classname(), [
	    'name' => 't2',
	    'addonOptions' => [
	        'asButton' => true,
	        'buttonOptions' => ['class' => 'btn btn-info']
	    ]
	]);?>

    <?= $form->field($model, 'pic_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
