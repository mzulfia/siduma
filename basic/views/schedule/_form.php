<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

use app\models\Shift;

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

    <?= $form->field($model, 'shift_id')->dropDownList(ArrayHelper::map(Shift::find()->all(), 'shift_id', 'shift_name'), ['prompt'=>'-Select Shift-']) ?>

    <p>
        *Office Hour: 07:00-15:00, Sore: 15:00-23:00, Malam : 23:00-07:00
    </p>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
