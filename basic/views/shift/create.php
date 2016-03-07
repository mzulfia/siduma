<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\time\TimePicker;


/* @var $this yii\web\View */
/* @var $model app\models\Shift */

$this->title = 'Shifts | Create Shift';
$this->params['breadcrumbs'][] = ['label' => 'Shifts', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Create Shift';
?>
<div class="shift-create">
	<div class="box box-info">
	  <div class="box-header with-border">
	    <h3 class="box-title">Create Shift</h3>
	  </div><!-- /.box-header -->
  	  <div class="box-body">
  	  	 <?php $form = ActiveForm::begin(); ?>

		    <?= $form->field($model, 'shift_name')->textInput(['maxlength' => true]) ?>

		    <?= $form->field($model, 'shift_start')->widget(TimePicker::classname(), [
			    'name' => 't1',
			    'pluginOptions' => [
				    'showSeconds' => true,
				    'showMeridian' => false,
				    'minuteStep' => 1,
				    'secondStep' => 5,
				    'defaultTime' => '00:00:00'
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
				    'defaultTime' => '00:00:00'
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
  	</div>  	
</div>
